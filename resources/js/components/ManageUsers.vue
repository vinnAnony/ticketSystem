<template>
  <div class="row justify-content-center mt-2" v-if="$gate.isAdmin() || $gate.isStaff()">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                <h3 class="card-title">Users</h3>

                <div class="card-tools row">
                    
                    <button class="btn btn-success mr-2" data-toggle="modal" data-target="#addUserModal" @click="newUserModal">
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
                        <th>Modify</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user in users" :key="user.id">
                        <td>{{user.id}}</td>
                        <td>{{user.name}}</td>
                        <td>{{user.email}}</td>
                        <td>{{user.role}}</td>
                        <td>
                            <a href="#"  @click="editUserModal(user)">
                            <i class="fas fa-edit fa-lg blue mr-5"></i>
                            </a>
                            <a href="#" @click="deleteUser(user.id)">
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

        <div v-if="!$gate.isAdmin() && !$gate.isStaff()">
            <not-found></not-found>
        </div>

        <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editMode" id="addUserModalLabel">Add New User</h5>
                        <h5 class="modal-title" v-show="editMode" id="addUserModalLabel">Edit User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode? updateUser() : createUser()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input v-model="form.name" type="text" name="name" placeholder="Full name"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input v-model="form.username" type="text" name="username" placeholder="Username"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('username') }">
                                <has-error :form="form" field="username"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input v-model="form.email" type="email" name="email" placeholder="Email"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                <has-error :form="form" field="email"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Role</label>
                                <select v-model="form.role" type="text" name="role"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('role') }">
                                    <option value="" selected disabled>Select Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="staff">Staff</option>
                                    <option value="customer">Customer</option>
                                </select>
                                <has-error :form="form" field="role"></has-error>
                            </div>
                            <div v-show="!editMode" class="form-group">
                                <label>Password</label>
                                <input v-model="form.password" type="password" name="password" placeholder="Password"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                <has-error :form="form" field="password"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button  :disabled="form.busy" type="submit" class="btn btn-primary" v-show="!editMode">Create</button>
                            <button  :disabled="form.busy" type="submit" class="btn btn-success" v-show="editMode">Modify</button>
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
            editMode: false,
            users: [],
            form: new Form(
                {
                id: '',
                name: '',
                username: '',
                email: '',
                password: '',
                role: '',
            }),
        }
    },

    methods: {
        
        fetchUsers(){
            if(this.$gate.isAdmin() || this.$gate.isStaff()){
                axios.get("api/users").then(({data}) => (this.users = data.data));
            }
        },

        createUser(){
            this.$Progress.start();
            this.form.post('api/users').then(() => {
                Fire.$emit('AfterUserCreate');
                $('#addUserModal').modal('hide');
                Toast.fire({
                        icon: 'success',
                        title: 'User created successfully'
                        });
                this.$Progress.finish();
            })
            .catch(() => {
                    this.$Progress.fail();
                    Toast.fire({
                        icon: 'error',
                        title: 'An error occurred!'
                        });
                });
            
        },

        updateUser(){
            this.$Progress.start();
            this.form.put('api/users/'+this.form.id)
                .then(() => {
                    $('#addUserModal').modal('hide');
                    Toast.fire({
                        icon: 'success',
                        title: 'User modified successfully'
                        });
                    Fire.$emit('AfterUserCreate');
                    this.$Progress.finish();
                })
                .catch(()=>{
                    Swal.fire(
                    'Error!',
                    'An error occurred!',
                    'error'
                    );
                    this.$Progress.fail();
                });
        },

        deleteUser(id){
            Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete user!'
                    }).then((result) => {
                        //send delete request to server
                        if (result.value) {
                            this.$Progress.start();
                            axios.delete('api/users/'+id)
                                .then(() => {
                                    Toast.fire({
                                        icon: 'success',
                                        title: 'User deleted successfully'
                                        });
                                    Fire.$emit('AfterUserCreate');
                                    this.$Progress.finish();
                                })
                                .catch(()=>{
                                    Swal.fire(
                                    'Error!',
                                    'An error occurred!',
                                    'error'
                                    );
                                    this.$Progress.fail();
                                });
                        }
                    })
        },

        newUserModal(){
            this.editMode = false;
            this.form.reset();
            $('#addUserModal').modal('show');
        },

        editUserModal(user){
            this.editMode = true;
            this.form.reset();
            this.form.fill(user);
            $('#addUserModal').modal('show');
        },
    },

    created(){
        this.fetchUsers();
        Fire.$on('AfterUserCreate', () => {
            this.fetchUsers();
        });
        //Fetch users every 3 seconds
        //setInterval(() => {this.fetchUsers()}, 3000);
    },

}
</script>

<style>

</style>