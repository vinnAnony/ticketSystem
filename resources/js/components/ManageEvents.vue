<template>
  <div class="row justify-content-center mt-2" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                <h3 class="card-title">Users</h3>

                <div class="card-tools row">
                    
                    <button class="btn btn-success mr-2" data-toggle="modal" data-target="#addUserModal">
                        <i class="fas fa-user-plus"></i> Add User
                    </button>
                </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr >
                        <td>Boy</td>
                        <td>boy</td>
                        <td>boy@mail.com</td>
                        <td>Boyyyy</td>
                        <td>
                            <a href="#" >
                            <i class="fas fa-edit fa-lg blue mr-5"></i>
                            </a>
                            <a href="#" >
                            <i class="fas fa-trash fa-lg red"></i>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                </div>
                <!-- /.card-body -->
            </div>
        <!-- /.card -->
        </div>

        <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                        <h5 class="modal-title" id="addUserModalLabel">Edit User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form >
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" name="name" placeholder="Full name"
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" placeholder="Username"
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" placeholder="Email"
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Role</label>
                                <select type="text" name="role"
                                    class="form-control">
                                    <option value="" selected disabled>Select Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="standard">Standard User</option>
                                </select>
                            </div>
                            <div v-show="!editMode" class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" placeholder="Password"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                            <button type="submit" class="btn btn-success">Modify</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {

    data(){
        return{
            form: new Form(
                {
                event_name: '',
            }),
        }
    },

}
</script>

<style>

</style>