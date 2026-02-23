<!DOCTYPE html>
<html lang="en">
<head>
    @include('general-layout.head')
    <style>
      table {
          width: 100%;
          border-collapse: collapse;
      }

      .header {
            text-align: center;
            border-bottom: 2px solid black;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

      th, td {
          border: 1px solid black;
          padding: 8px;
      }

      th {
          background: #eee;
      }
  </style>
</head>
<body>
  <div class="header">
    <h2>eLibrary</h2>
    <p>Koleksi Buku Lengkap di Indonesia</p>
  </div>
  <table class="table table-striped">
    <thead>
      <tr>
        <th class="text-center">Code</th>
        <th class="text-center">Title</th>
        <th class="text-center">Author</th>
        <th class="text-center">Category</th>
      </tr>
    </thead>
    <tbody>
      @forelse($data as $item)
      <tr>
          <td class="">{{ $item->kode }}</td>
          <td class="">{{ $item->judul }}</td>
          <td class="">{{ $item->pengarang }}</td>
          <td class="">{{ $item->category->nama_kategori }}</td>
      </tr>
      @empty
      <tr>
          <td colspan="4" class="align-item-center text-center">No books is found.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</body>
</html>
