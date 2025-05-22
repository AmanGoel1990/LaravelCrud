@if (session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger mt-3">
        {{ session('error') }}
    </div>
@endif

<!-- Styles -->
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
    .margin-top-20 {
        margin-top: 20px;
    }
</style>

<!-- Import Form -->
<h2 class="mb-4 mt-4">📁 Import Contacts (XML)</h2>

<form action="{{ route('contacts.import') }}" method="POST" enctype="multipart/form-data" class="p-4 border rounded shadow-sm bg-light">
    @csrf
    <div class="mb-3">
        <label for="xml_file" class="form-label">Choose XML File</label>
        <input type="file" name="xml_file" id="xml_file" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">🚀 Import</button>
</form>

<!-- Contacts Table -->
<div class="container margin-top-20">
    <div class="panel panel-primary">
        <div class="panel-body">
            <table class="table table-bordered" id="datatable">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($contacts as $contact)
                    <tr>
                        <td>{{ $contact->name }}</td>
                        <td>{{ $contact->phone }}</td>
                        <td>
                            <!-- Edit Button -->
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $contact->id }}">
                                Edit
                            </button>

                            <!-- Delete Button -->
                            <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this contact?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal{{ $contact->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $contact->id }}" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <form action="{{ route('contacts.update', $contact->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                              <h5 class="modal-title" id="editModalLabel{{ $contact->id }}">Edit Contact</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <div class="mb-3">
                                  <label>Name</label>
                                  <input type="text" name="name" class="form-control" value="{{ $contact->name }}" required>
                              </div>
                              <div class="mb-3">
                                  <label>Phone</label>
                                  <input type="text" name="phone" class="form-control" value="{{ $contact->phone }}" required>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                              <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    $('#datatable').DataTable();
});
</script>
