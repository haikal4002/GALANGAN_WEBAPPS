import pandas as pd
import os
import datetime

# --- KONFIGURASI ---
SOURCE_FILE = 'FIX_PO_Barang_Hadi_Jaya_Makmur.xlsx' # Nama file Excel Anda
SHEET_NAME = 'LAP CASH FLOW'                        # Nama Sheet
OUTPUT_SQL = 'import_cashflows.sql'                 # Nama file output

# Mapping KD (Excel) ke transaction_code_id (Database)
# Sesuaikan ID sebelah kanan dengan ID di tabel transaction_codes Anda
TRX_MAP = {
    11: 1,  # Pemasukan -> ID 1
    13: 2,  # Pengeluaran/Kulak -> ID 2
    14: 3,  # Operasional -> ID 3
    12: 3,  # Upah (masuk operasional) -> ID 3
    15: 4   # Saldo Awal -> ID 4 (Pastikan ID ini ada di DB atau ganti ke yg sesuai)
}

def clean_currency(val):
    """Membersihkan format mata uang menjadi angka float/int"""
    try:
        if pd.isna(val) or str(val).strip() in ['-', '']:
            return 0
        # Hapus Rp, titik ribuan, dan spasi, ganti koma desimal jika ada
        val_str = str(val).replace('Rp', '').replace('.', '').replace(',', '').strip()
        return float(val_str)
    except:
        return 0

def clean_date(val):
    """Format tanggal ke YYYY-MM-DD"""
    try:
        if pd.isna(val):
            return datetime.date.today().strftime('%Y-%m-%d')
        
        # Jika input sudah datetime object (dari Excel)
        if isinstance(val, datetime.datetime):
            return val.strftime('%Y-%m-%d')
            
        # Jika input string
        dt = pd.to_datetime(str(val), errors='coerce')
        if pd.notna(dt):
            return dt.strftime('%Y-%m-%d')
        return datetime.date.today().strftime('%Y-%m-%d')
    except:
        return datetime.date.today().strftime('%Y-%m-%d')

def generate_sql():
    print(f"⏳ Membaca file: {SOURCE_FILE}...")
    
    if not os.path.exists(SOURCE_FILE):
        print(f"❌ Error: File '{SOURCE_FILE}' tidak ditemukan.")
        return

    try:
        # Baca Excel
        df = pd.read_excel(SOURCE_FILE, sheet_name=SHEET_NAME)
        
        # Filter: Pastikan kolom TANGGAL tidak kosong
        df = df.dropna(subset=['TANGGAL'])
        
        print(f"   Ditemukan {len(df)} baris data.")
        
        with open(OUTPUT_SQL, 'w', encoding='utf-8') as f:
            # 1. HEADER SQL
            f.write("-- Auto-generated SQL script\n")
            f.write("SET FOREIGN_KEY_CHECKS=0;\n")
            f.write("TRUNCATE TABLE cashflows;\n") # Menghapus semua data lama
            f.write("SET FOREIGN_KEY_CHECKS=1;\n\n")
            
            # 2. GENERATE INSERTS
            count = 0
            for index, row in df.iterrows():
                # Ambil dan bersihkan data
                tgl = clean_date(row.get('TANGGAL'))
                
                # Mapping KD
                kd_raw = row.get('KD')
                try:
                    kd_int = int(kd_raw) if pd.notna(kd_raw) else 11
                except:
                    kd_int = 11
                trx_id = TRX_MAP.get(kd_int, 1) # Default ke 1 jika tidak ada di map
                
                ket = str(row.get('KETERANGAN', '-')).replace("'", "\\'") # Escape tanda petik
                debit = clean_currency(row.get('DEBIT'))
                kredit = clean_currency(row.get('KREDIT'))
                
                # Buat Query INSERT
                # created_at dan updated_at diset ke waktu transaksi agar konsisten
                sql = f"INSERT INTO cashflows (tanggal, transaction_code_id, keterangan, debit, kredit, created_at, updated_at) VALUES ('{tgl}', {trx_id}, '{ket}', {debit}, {kredit}, '{tgl} 00:00:00', '{tgl} 00:00:00');\n"
                
                f.write(sql)
                count += 1
            
            print(f"✅ Berhasil! File '{OUTPUT_SQL}' telah dibuat dengan {count} perintah insert.")
            print("   Silakan jalankan file SQL tersebut di database Anda.")

    except Exception as e:
        print(f"❌ Terjadi kesalahan: {e}")

if __name__ == "__main__":
    generate_sql()