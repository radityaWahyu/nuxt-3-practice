<?php

namespace Database\Seeders;

use App\Models\Hari;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Jurusan;
use App\Models\Pegawai;
use App\Models\Ruangan;
use App\Models\Semester;
use App\Models\JamPelajaran;
use App\Models\Pembelajaran;
use App\Models\MataPelajaran;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DataAwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $dataHari = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'];
        $dataJam = [
            [
                'nama' => '1',
                'jam_mulai' => '06:45',
                'jam_berakhir' => '07:30',
            ],
            [
                'nama' => '2',
                'jam_mulai' => '06:45',
                'jam_berakhir' => '07:30',
            ],
        ];

        DB::beginTransaction();
        try {
            $semester = Semester::create(
                [
                    'tahun_ajaran' => '2023',
                    'nama' => 'Tahun Pelajaran 2023/2024 Genap',
                    'semester' => 2,
                    'is_aktif' => 1,
                ]
            );

            $jurusan  = Jurusan::create([
                'nama' => 'Rekayasa Perangkat Lunak'
            ]);

            $ruangan = Ruangan::create([
                'nama' => 'E 202',
            ]);


            $pegawai = new Pegawai();
            $pegawai->nama = 'Raditya Wahyu Sasono';
            $pegawai->jenis_kelamin = 'L';
            $pegawai->jenis_pegawai = 'guru';
            $pegawai->email = 'radityaw@gmail.com';
            $pegawai->save();

            $userPegawai = new User([
                'username' => 'administrator',
                'password' => Hash::make('123456'),
            ]);

            $pegawai->user()->save($userPegawai);


            $siswa = new Siswa([
                'nama' => 'Levian Arta',
                'jenis_kelamin' => 'L',
                'tgl_masuk' => '2023-01-01',
                'email' => 'levian@gmail.com',
                'id_jurusan' => $jurusan->id,
            ]);
            $siswa->save();

            $userSiswa = new User([
                'username' => 'levian',
                'password' => Hash::make('123456'),
            ]);

            $siswa->user()->save($userSiswa);

            $kelas = Kelas::create([
                'nama' => 'X RPL',
                'id_semester' => $semester->id,
                'id_jurusan' => $jurusan->id,
                'id_guru' => $pegawai->id,
            ]);


            $mapel = MataPelajaran::create([
                'nama_mapel' => 'Bahasa Indonesia',
            ]);

            foreach ($dataHari as $hari) {
                Hari::create([
                    'nama' => $hari
                ]);
            }

            foreach ($dataJam as $jam) {
                $jamPelajaran = JamPelajaran::create([
                    'nama' => $jam['nama'],
                    'jam_mulai' => $jam['jam_mulai'],
                    'jam_berakhir' => $jam['jam_berakhir'],
                ]);
            }



            $pembelajaran = Pembelajaran::create([
                'id_semester' => $semester->id,
                'id_kelas' => $kelas->id,
                'id_guru' => $pegawai->id,
                'id_mapel' => $mapel->id,

            ]);

            $pembelajaran->pembelajaran_detail()->create(
                [
                    'id_pembelajaran' => $pembelajaran->id,
                    'id_jam' => 1,
                    'id_hari' => 1,
                ],

            );
            $pembelajaran->pembelajaran_detail()->create(
                [
                    'id_pembelajaran' => $pembelajaran->id,
                    'id_jam' => 2,
                    'id_hari' => 1,
                ],

            );

            DB::commit();
        } catch (\Exception $e) {
            //     //throw $th;
            print_r($e->getMessage());
            DB::rollBack();
        }
    }
}
