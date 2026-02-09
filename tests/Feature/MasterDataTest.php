<?php

use App\Models\User;
use App\Models\MasterProduct;
use App\Models\MasterUnit;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('can access master data index', function () {
    $response = $this->get(route('master.index'));
    $response->assertStatus(200);
});

test('can store master product', function () {
    $response = $this->post(route('master-product.store'), [
        'nama' => 'SEMEN TIGA RODA'
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('master_products', [
        'nama' => 'SEMEN TIGA RODA'
    ]);
});

test('can update master product', function () {
    $product = MasterProduct::create(['nama' => 'SEMEN GRESIK']);

    $response = $this->put(route('master-product.update', $product->id), [
        'nama' => 'SEMEN GRESIK UPDATE'
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('master_products', [
        'id' => $product->id,
        'nama' => 'SEMEN GRESIK UPDATE'
    ]);
});

test('can delete master product', function () {
    $product = MasterProduct::create(['nama' => 'SEMEN PADANG']);

    $response = $this->delete(route('master-product.destroy', $product->id));

    $response->assertRedirect();
    $this->assertDatabaseMissing('master_products', [
        'id' => $product->id
    ]);
});

test('can store master unit', function () {
    $response = $this->post(route('master-unit.store'), [
        'nama' => 'KILOGRAM'
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('master_units', [
        'nama' => 'KILOGRAM'
    ]);
});

test('can update master unit', function () {
    $unit = MasterUnit::create(['nama' => 'METER']);

    $response = $this->put(route('master-unit.update', $unit->id), [
        'nama' => 'CENTIMETER'
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('master_units', [
        'id' => $unit->id,
        'nama' => 'CENTIMETER'
    ]);
});

test('can delete master unit', function () {
    $unit = MasterUnit::create(['nama' => 'LITER']);

    $response = $this->delete(route('master-unit.destroy', $unit->id));

    $response->assertRedirect();
    $this->assertDatabaseMissing('master_units', [
        'id' => $unit->id
    ]);
});

test('can store supplier', function () {
    $response = $this->post(route('supplier.store'), [
        'nama' => 'PT JAYA ABADI',
        'kontak' => '08123456789',
        'alamat' => 'Surabaya'
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('suppliers', [
        'nama' => 'PT JAYA ABADI',
        'kontak' => '08123456789',
        'alamat' => 'Surabaya'
    ]);
});

test('can update supplier', function () {
    $supplier = Supplier::create([
        'nama' => 'TOKO BESI MURAH',
        'kontak' => '-',
        'alamat' => '-'
    ]);

    $response = $this->put(route('supplier.update', $supplier->id), [
        'nama' => 'TOKO BESI UPDATE',
        'kontak' => '0899',
        'alamat' => 'Jakarta'
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('suppliers', [
        'id' => $supplier->id,
        'nama' => 'TOKO BESI UPDATE'
    ]);
});

test('can delete supplier', function () {
    $supplier = Supplier::create([
        'nama' => 'SUPPLIER LAMA',
        'kontak' => '-',
        'alamat' => '-'
    ]);

    $response = $this->delete(route('supplier.destroy', $supplier->id));

    $response->assertRedirect();
    $this->assertDatabaseMissing('suppliers', [
        'id' => $supplier->id
    ]);
});
