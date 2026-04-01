@extends('layouts.template')

@section('styles')
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        /* Navbar */
        .navbar {
            background-color: #2c3e50;
        }

        /* Header tabel */
        .table thead th {
            background-color: #2c3e50 !important;
            color: white !important;
        }

        /* Baris ganjil */
        .table tbody tr:nth-child(odd) td {
            background-color: #ccd5ae !important;
        }

        /* Baris genap */
        .table tbody tr:nth-child(even) td {
            background-color: #ffafcc !important;
        }

        /* Hover */
        .table tbody tr:hover td {
            background-color: #f1faee !important;
        }
    </style>
@endsection

@section('content')
    <!-- Container -->
    <div class="container mt-4">

        <!-- Card -->
        <div class="card shadow">

            <!-- Card Header -->
            <div class="card-header">
                <h3>Tabel Data</h3>
            </div>

            <!-- Card Body -->
            <div class="card-body">

                <!-- Table -->
                <table class="table table-bordered">

                    <!-- Table Head -->
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody>

                        <tr>
                            <td>1</td>
                            <td>Gunung Merapi</td>
                            <td>Gunung berapi aktif.</td>
                        </tr>

                        <tr>
                            <td>2</td>
                            <td>Malioboro</td>
                            <td>Kawasan wisata terkenal.</td>
                        </tr>

                        <tr>
                            <td>3</td>
                            <td>Candi Borobudur</td>
                            <td>Candi Buddha terbesar.</td>
                        </tr>

                        <tr>
                            <td>4</td>
                            <td>Pantai Parangtritis</td>
                            <td>Pantai populer di Yogyakarta.</td>
                        </tr>

                        <tr>
                            <td>5</td>
                            <td>Tugu Yogyakarta</td>
                            <td>Ikon kota Yogyakarta.</td>
                        </tr>

                    </tbody>

                </table>

            </div>
        </div>

    </div>
@endsection