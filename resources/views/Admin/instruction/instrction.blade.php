@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Instruction</h3>
    </div>
    <div class="col-12 col-xl-4">
        <div class="justify-content-end d-flex">
            <a href="{{route("admin.instructions.create")}}" class="btn btn-primary">Add Instruction</a>
        </div>
    </div>
@endsection

@section('content')
    <div class="col-12 mt-3">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Instruction</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($instructions as $index => $instruction)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                @if(strlen($instruction->instruction) > 10)
                                    {{ Str::limit($instruction->instruction, 50) }}
                                    <a href="#" data-toggle="tooltip" title="{{ $instruction->instruction }}">[...]</a>
                                @else
                                    {{ $instruction->instruction }}
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.instructions.delete', $instruction->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this instruction?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center">No Instruction uploaded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection