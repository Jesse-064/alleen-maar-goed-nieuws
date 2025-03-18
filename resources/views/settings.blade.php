@extends('components.layout')

@section('title', 'Session Variables')

@section('slot')
    <div class="container">
        <h1 class="mt-4">Session Variables</h1>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Variable</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                @if (empty(session()->all()))
                    <tr>
                        <td colspan="2" class="text-center">No session variables set.</td>
                    </tr>
                @else
                    @foreach (session()->all() as $key => $value)
                        <tr>
                            <td>{{ htmlspecialchars($key) }}</td>
                            <td>{{ is_array($value) ? htmlspecialchars(print_r($value, true)) : htmlspecialchars($value) }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
@endsection