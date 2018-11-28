@extends('backend.layouts.master')

@section('content')
<br><br>
<div id="message" class="text-success text-center" style="display: none;"></div>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" id="add_blog_btn">
  Add Blog
</button>

<!-- Modal -->
<div class="modal fade" id="blogModal" tabindex="-1" role="dialog" aria-labelledby="categoryleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="blogForm" enctype="multipart/form-data">
      {{csrf_field()}}
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="categoryleModalLabel">Add New Blog</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Blog Title</label>
          <input type="text" id="blogTitle" name="blogTitle" class="form-control">
        </div>
        <div class="form-group">
          <label>Category Name</label>
          <select class="form-control" id="categoryId" name="categoryId">
            <option value="">Select category</option>
            @foreach($published_categories as $published_category)
            <option value="{{$published_category->id}}">{{$published_category->categoryName}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label>Author Name</label>
          <input type="text" name="authorName" id="authorName" class="form-control">
        </div>
        <div class="form-group">
          <label>Short Description</label>
          <textarea class="form-control" id="shortDescription" name="shortDescription"></textarea>
        </div>
        <div class="form-group">
          <label>Long Description</label>
          <textarea class="form-control" id="longDescription" name="longDescription"></textarea>
        </div>
        <div class="form-group">
          <label>Blog Image</label>
          <input type="file" name="blogImage" id="blogImage">
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
<table class="table-bordered table table-hover" id="blogTable">
  <thead>
    <tr>
      <th>ID</th>
      <th>categoryId</th>
      <th>blogTitle</th>
      <th>authorName</th>
      <th>publicationStatus</th>
    </tr>
  </thead>
</table>
<script>
  $(document).ready(function(){
    $('#blogTable').DataTable({
      "processing":true,
      "serverSide":true,
      "ajax":"{{URL::to('/show_blog')}}",
      "columns":[
       {data:"id"},
       {data:"categoryId"},
       {data:"blogTitle"},
       {data:"authorName"},
       {data:"publicationStatus"}
      ]
    })
    $('#add_blog_btn').click(function(){
      $('#blogModal').modal('show');
      $('#blogForm')[0].reset();
      $('#submit').val('Save');
      $('#acction_btn').val('insert');
      $('message').html('');
    });
    $('#blogForm').on('submit',function(e){
      e.preventDefault();
      // var form_data = $(this).serialize();
      // alert(form_data);
      $.ajax({
        url:"{{URL::to('/save_blog')}}",
        method:'post',
        data:new FormData(this),
        dataType:"JSON",
        contentType : false,
        processData : false,
        success:function(result){
          $('#message').show();
          $('#message').html(result.success);
          $('#blogForm')[0].reset();
          $('#blogModal').modal('hide');
          $('#blogTable').DataTable().ajax.reload();
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
          $('#blogModal').modal('show');
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
            $('#blogTable').DataTable().ajax.reload();
          }
        });
      }
    });
  })
</script>
@endsection