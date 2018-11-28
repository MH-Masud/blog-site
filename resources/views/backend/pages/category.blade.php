@extends('backend.layouts.master')

@section('content')
<br><br>
<div id="message" class="text-success text-center" style="display: none;"></div>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" id="add_category_btn">
  Add Category
</button>

<!-- Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="categoryleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="categoryForm">
      {{csrf_field()}}
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="categoryleModalLabel">Add New Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Category Name</label>
          <input type="text" id="categoryName" name="categoryName" class="form-control">
        </div>
        <div class="form-group">
          <label>Category Description</label>
          <textarea class="form-control" id="categoryDescription" name="categoryDescription"></textarea>
        </div>
        <div class="form-group">
          <select class="form-control" id="publicationStatus" name="publicationStatus">
            <option value="">Select Status</option>
            <option value="1">Published</option>
            <option value="0">Unpublished</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="hidden" name="acction_btn" id="acction_btn">
        <input type="hidden" name="categoryID" id="categoryID">
        <input type="submit" name="submit" id="submit" value="" class="btn btn-info btn-lg">
      </div>
    </div>
    </form>
  </div>
</div><br><br>
<table class="table-bordered table table-hover" id="categoryTable">
  <thead>
    <tr>
      <th>ID</th>
      <th>Category Name</th>
      <th>Category Description</th>
      <th>Publication Status</th>
      <th>Action</th>
    </tr>
  </thead>
</table>
<script>
  $(document).ready(function(){
    $('#categoryTable').DataTable({
      "processing":true,
      "serverSide":true,
      "ajax":"{{URL::to('/showcategory')}}",
      "columns":[
       {data:"id"},
       {data:"categoryName"},
       {data:"categoryDescription"},
       {data:"publicationStatus"},
       {data:"action",orderable:false,searchable:false}
      ]
    })
    $('#add_category_btn').click(function(){
      $('#categoryModal').modal('show');
      $('#categoryForm')[0].reset();
      $('#submit').val('Save');
      $('#acction_btn').val('insert');
      $('message').html('');
    });
    $('#categoryForm').on('submit',function(e){
      e.preventDefault();
      var form_data = $(this).serialize();
      // alert(form_data);
      $.ajax({
        url:"{{URL::to('/save_category')}}",
        method:'post',
        data:form_data,
        dataType:'json',
        success:function(result){
          $('#message').show();
          $('#message').html(result.success);
          $('#categoryForm')[0].reset();
          $('#categoryModal').modal('hide');
          $('#categoryTable').DataTable().ajax.reload();
        }
      });
    });
    $(document).on('click','.edit',function(){
      var id = $(this).attr('id');
      $('#message').html('');
      $.ajax({
        url:"{{URL::to('/editcategory')}}",
        method:"get",
        data:{id:id},
        dataType:'json',
        success:function(result){
          $('#categoryID').val(id);
          $('#categoryName').val(result.categoryName);
          $('#categoryDescription').val(result.categoryDescription);
          $('#publicationStatus').val(result.publicationStatus);
          $('#categoryModal').modal('show');
          $('#submit').val('Update');
          $('#acction_btn').val('update');
        }
      });
    });
    $(document).on('click','.delete', function(){
      
      var r = confirm("Are you sure!You want to delete this");
      var id = $(this).attr('id');
      // alert(id);
      $('#message').html('');
      if (r == true) {
        $.ajax({
          url:"{{URL::to('/deletecategory')}}",
          method:"get",
          data:{id:id},
          dataType:'json',
          success:function(result){
            $('#message').show();
            $('#message').html(result.success);
            $('#categoryTable').DataTable().ajax.reload();
          }
        });
      }
    });
  })
</script>
@endsection