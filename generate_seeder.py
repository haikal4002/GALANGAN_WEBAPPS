import pandas as pd
import os
import datetime
import re

# --- KONFIGURASI FILE ---
EXCEL_SOURCE = 'FIX PO Barang Hadi Jaya Makmur.xlsx'

SHEET_MASTER = 'MASTER STOCK'
SHEET_CASHFLOW = 'LAP CASH FLOW'
SHEETS_BULANAN = [
    'JULI 25', 'AGS 25', 'SEP 25', 'OKT 25', 
    'NOV 25', 'DES 25', 'JAN 26'
]

# --- MAPPING ---
UNIT_MAP_DEFAULT = 5 
UNIT_KEYWORDS = {
    'SAK': 1, 'SEMEN': 1, 'GALON': 2, 'CAT': 2, 'KG': 3, 'PAKU': 3, 
    'KAWAT': 3, 'PICK UP': 4, 'PASIR': 4, 'PCS': 5, 'KARUNG': 6, 
    'BOX': 7, 'KUBIK': 8, 'ONS': 9, 'GRAM': 11
}

TRX_CODE_MAP = { 11: 1, 13: 2, 14: 3, 12: 3, 15: 4 }

# --- FUNGSI PEMBERSIH ---
def clean_price(x):
    try:
        if pd.isna(x) or str(x).strip() in ['-', '']: return 0
        return float(str(x).replace(',', '').replace('Rp', '').replace('.', '').strip())
    except:
        return 0

def get_unit_id(product_name):
    name_upper = str(product_name).upper()
    for key, unit_id in UNIT_KEYWORDS.items():
        if key in name_upper: return unit_id
    return UNIT_MAP_DEFAULT

def clean_date(val):
    if pd.isna(val): return '2026-01-01'
    val_str = str(val).strip()
    match_typo = re.match(r'^(\d{1,2})/(\d{2})(\d{4})$', val_str)
    if match_typo:
        val_str = f"{match_typo.group(1)}/{match_typo.group(2)}/{match_typo.group(3)}"
    try:
        dt = pd.to_datetime(val_str, dayfirst=True, errors='coerce')
        if pd.isna(dt): return datetime.date.today().strftime('%Y-%m-%d')
        return dt.strftime('%Y-%m-%d')
    except:
        return '2026-01-01'

print(f"⏳ Membaca file Excel: {EXCEL_SOURCE}...")

if not os.path.exists(EXCEL_SOURCE):
    print(f"❌ ERROR: File '{EXCEL_SOURCE}' tidak ditemukan!")
    exit()

# 1. MASTER DATA
print(f"   -> Membaca Sheet '{SHEET_MASTER}'...")
df_master = pd.read_excel(EXCEL_SOURCE, sheet_name=SHEET_MASTER).dropna(subset=['NAMA BARANG'])

unique_suppliers = df_master['SUPPLIER'].dropna().unique()
supplier_map = {name: i+1 for i, name in enumerate(unique_suppliers)}

unique_products = df_master['NAMA BARANG'].dropna().unique()
product_map = {name: i+1 for i, name in enumerate(unique_products)}

df_units = df_master.copy()
df_units['master_product_id'] = df_units['NAMA BARANG'].map(product_map)
df_units['supplier_id'] = df_units['SUPPLIER'].map(supplier_map).fillna(1).astype(int)
df_units['master_unit_id'] = df_units['NAMA BARANG'].apply(get_unit_id)
df_units['harga_beli'] = df_units['HARGA BELI '].apply(clean_price)
df_units['harga_jual'] = df_units['HARGA JUAL'].apply(clean_price)
# Baca Kolom HARGA ATAS
df_units['harga_atas'] = df_units['HARGA ATAS'].apply(clean_price)
df_units['stok'] = df_units['QTY'].apply(clean_price).astype(int)

# 2. TRANSAKSI POS
all_trx_items = []
print(f"   -> Memproses {len(SHEETS_BULANAN)} sheet bulanan...")

for sheet_name in SHEETS_BULANAN:
    try:
        df_header = pd.read_excel(EXCEL_SOURCE, sheet_name=sheet_name, header=None, nrows=4)
        date_row = df_header.iloc[3]
        date_cols = {}
        for idx, val in date_row.items():
            if isinstance(val, str) and val.startswith('20'):
                date_cols[idx] = clean_date(val)
                
        df_data = pd.read_excel(EXCEL_SOURCE, sheet_name=sheet_name, header=None, skiprows=4)
        for idx, date_str in date_cols.items():
            for _, row in df_data.iterrows():
                product_name = row[0]
                qty = row[idx]
                try: qty = float(qty)
                except: qty = 0
                
                if qty > 0 and isinstance(product_name, str) and product_name in product_map:
                    p_id = product_map[product_name]
                    unit_info = df_units[df_units['master_product_id'] == p_id]
                    price = unit_info['harga_jual'].values[0] if not unit_info.empty else 0
                    p_unit_id = int(unit_info.index[0]) + 1 if not unit_info.empty else 1

                    all_trx_items.append({
                        'date': date_str,
                        'product_unit_id': p_unit_id,
                        'qty': qty,
                        'harga_satuan': price,
                        'subtotal': qty * price
                    })
    except Exception as e:
        print(f"      ⚠️ Warning sheet '{sheet_name}': {e}")

df_sales = pd.DataFrame(all_trx_items)
transactions = []
transaction_items = []

if not df_sales.empty:
    trx_groups = df_sales.groupby('date')
    trx_counter = 1
    for date, group in trx_groups:
        total = group['subtotal'].sum()
        transactions.append({
            'id': trx_counter,
            'no_trx': f"TRX-{str(date).replace('-','')}-LEGACY",
            'user_id': 1,
            'total_amount': total,
            'bayar_amount': total,
            'kembalian': 0,
            'payment_method': 'cash',
            'created_at': f"{date} 12:00:00",
            'updated_at': f"{date} 12:00:00"
        })
        for _, item in group.iterrows():
            transaction_items.append({
                'pos_transaction_id': trx_counter,
                'product_unit_id': item['product_unit_id'],
                'qty': item['qty'],
                'harga_satuan': item['harga_satuan'],
                'subtotal': item['subtotal'],
                'created_at': f"{date} 12:00:00",
                'updated_at': f"{date} 12:00:00"
            })
        trx_counter += 1

# 3. CASHFLOW
print(f"   -> Membaca Sheet '{SHEET_CASHFLOW}'...")
df_cf = pd.read_excel(EXCEL_SOURCE, sheet_name=SHEET_CASHFLOW).dropna(subset=['TANGGAL'])
cashflows = []
for _, row in df_cf.iterrows():
    kd_asal = int(row['KD']) if pd.notna(row['KD']) else 11
    trx_code_id = TRX_CODE_MAP.get(kd_asal, 1)
    debit = clean_price(row['DEBIT'])
    kredit = clean_price(row['KREDIT'])
    tgl_bersih = clean_date(row['TANGGAL'])
    
    cashflows.append({
        'tanggal': tgl_bersih,
        'transaction_code_id': trx_code_id,
        'keterangan': str(row['KETERANGAN']).replace("'", "\\'"),
        'debit': debit,
        'kredit': kredit,
        'created_at': f"{tgl_bersih} 00:00:00",
        'updated_at': f"{tgl_bersih} 00:00:00"
    })

# 4. GENERATE PHP
print("   -> Menulis file LegacyDataSeeder.php...")
def to_php(data_list):
    res = "[\n"
    for item in data_list:
        res += "            ["
        for k, v in item.items():
            if isinstance(v, str): res += f"'{k}' => '{v}', "
            else: res += f"'{k}' => {v}, "
        res += "],\n"
    res += "        ]"
    return res

php_content = f"""<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LegacyDataSeeder extends Seeder
{{
    public function run()
    {{
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        DB::table('suppliers')->truncate();
        DB::table('suppliers')->insert({to_php([{'id': v, 'nama': k, 'kontak': '-', 'alamat': '-'} for k, v in supplier_map.items()])});

        DB::table('master_products')->truncate();
        DB::table('master_products')->insert({to_php([{'id': v, 'nama': k} for k, v in product_map.items()])});

        DB::table('product_units')->truncate();
        $units = {to_php([{
            'id': i+1,
            'master_product_id': row['master_product_id'],
            'master_unit_id': row['master_unit_id'],
            'nilai_konversi': 1,
            'is_base_unit': 1,
            'stok': row['stok'],
            'harga_beli_terakhir': row['harga_beli'],
            'harga_jual': row['harga_jual'],
            'harga_atas': row['harga_atas'],
            'margin': 20,
            'created_at': '2026-01-01 00:00:00',
            'updated_at': '2026-01-01 00:00:00'
        } for i, row in df_units.iterrows()])};
        foreach (array_chunk($units, 50) as $chunk) {{ DB::table('product_units')->insert($chunk); }}

        DB::table('pos_transactions')->truncate();
        $trxs = {to_php(transactions)};
        foreach (array_chunk($trxs, 50) as $chunk) {{ DB::table('pos_transactions')->insert($chunk); }}

        DB::table('pos_transaction_items')->truncate();
        $trxItems = {to_php(transaction_items)};
        foreach (array_chunk($trxItems, 50) as $chunk) {{ DB::table('pos_transaction_items')->insert($chunk); }}

        DB::table('cashflows')->truncate();
        $cfs = {to_php(cashflows)};
        foreach (array_chunk($cfs, 50) as $chunk) {{ DB::table('cashflows')->insert($chunk); }}

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }}
}}
"""

with open('LegacyDataSeeder.php', 'w', encoding='utf-8') as f:
    f.write(php_content)

print("✅ SELESAI! File 'LegacyDataSeeder.php' berhasil diperbaiki.")