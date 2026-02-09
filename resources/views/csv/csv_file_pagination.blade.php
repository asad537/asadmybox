@extends('csv.csv_file')

@section('csv_data')
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email Address</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $row)
                            <tr>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->email }}</td>
                            </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! $data->links() !!}
        </div>

@endsection

