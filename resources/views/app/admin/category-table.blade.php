@forelse ($categories as $category)
    <tr>
        <th scope="row" class="p-3">{{ $loop->iteration }}</th>
        <td class="p-3">{{ Str::limit($category->namaKategori, 10, '...') }}</td>
        <td class="p-3">{{ Str::limit($category->deskripsi, 10, '...') }}</td>
        <td class="p-3">{{ $category->status == 1 ? 'Active' : 'Non Active' }}</td>
        <td class="p-3 table-mobile">
            <div class="my-2">
                <a href="" class="btn btn-primary border-0" style="background-color: #FFD460; width:100%">Show</a>
            </div>
            <div class="my-2">
                <a href="" class="btn btn-primary border-0"
                    style="background-color: #F07B3F; width:100%">Edit</a>
            </div>
        </td>
        <td class="p-3 table-web">
            <a href="{{ url('/category/' . $category->id) }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor"
                    class="bi bi-eye me-3" viewBox="0 0 16 16">
                    <path
                        d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                </svg></a>
            <a href="{{ url('/category/' . $category->id . '/edit') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor"
                    class="bi bi-pencil-square mx-3" viewBox="0 0 16 16">
                    <path
                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                    <path fill-rule="evenodd"
                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                </svg></a>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="p-3 text-center">Tidak Ada Data</td>
    </tr>
@endforelse
