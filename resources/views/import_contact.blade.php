<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
</head>
<style>
    .margin-top-20 {
    margin-top: 20px;
}
    </style>
<h2>Import Contacts (XML)</h2>

<form action="{{ route('contacts.import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div>
        <label for="xml_file">XML File:</label>
        <input type="file" name="xml_file" required>
    </div>
    <button type="submit">Import</button>
</form>

<div class="container margin-top-20">

    <div class="panel panel-primary">
        <div class="panel-heading">DataTable Custom Search Filter</div>
        <div class="panel-body">
            <table class="table table-bordered" id="datatable" cellspacing="0">
    <thead>
        <tr>
            <th>Name</th>
            <th>Phone Number<th>
            <th>Action<th>
        </tr>
    </thead>
    <tbody>
        <tr>
            
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>
</div>
    </div>

</div>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
		<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(function() {
    
    var datatable = $('#datatable').DataTable({
        dom: '<"#positionFilter">t'
    });
    
    $('#positionFilter').html('<input type="text" class="form-control" placeholder="Search by Position">');
    
    $(document).on('keyup', '#positionFilter input', function() {
        var value = $(this).val();
        console.log(value);
        datatable.columns(2).search(value).draw();
    });
    
});
    </script>