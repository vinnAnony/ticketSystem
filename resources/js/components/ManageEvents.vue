<template>
  <div class="row justify-content-center mt-2" v-if="$gate.isAdmin() || $gate.isStaff()">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                <h3 class="card-title">Events</h3>

                <div class="card-tools row">
                    
                    <button class="btn btn-success mr-2" data-toggle="modal" data-target="#addEventModal" @click="newEventModal">
                        <i class="fas fa-calendar-plus"></i> Add Event
                    </button>
                </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Event Name</th>
                        <th>Venue</th>
                        <th>Max. Attendees</th>
                        <th>Regular Price</th>
                        <th>VIP Price</th>
                        <th>Event Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="event in events" :key="event.id">
                        <td>{{event.id}}</td>
                        <td>{{event.event_name}}</td>
                        <td>{{event.venue_name}}</td>
                        <td>{{event.max_attendees}}</td>
                        <td>{{event.regular_price}}</td>
                        <td>{{event.vip_price}}</td>
                        <td>{{event.event_date}}</td>
                        <td>
                            <a href="#"  @click="editEventModal(event)">
                            <i class="fas fa-edit fa-lg blue mr-5"></i>
                            </a>
                            <a href="#" @click="deleteEvent(event.id)">
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

        <div class="modal fade" id="addEventModal" tabindex="-1" role="dialog" aria-labelledby="addEventModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editMode" id="addEventModalLabel">Add New Event</h5>
                        <h5 class="modal-title" v-show="editMode" id="addEventModalLabel">Edit Event</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode? updateEvent() : createEvent()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Event Name</label>
                                <input v-model="form.event_name" type="text" name="event_name" placeholder="Event name"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('event_name') }">
                                <has-error :form="form" field="event_name"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Event Venue</label>
                                <input v-model="form.venue_name" type="text" name="venue_name" placeholder="Event venue"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('venue_name') }">
                                <has-error :form="form" field="venue_name"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Max. Attendees</label>
                                <input v-model="form.max_attendees" type="number" name="max_attendees" placeholder="Max. attendees"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('max_attendees') }">
                                <has-error :form="form" field="max_attendees"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Regular Price</label>
                                <input v-model="form.regular_price" type="number" name="regular_price" placeholder="Regular price"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('regular_price') }">
                                <has-error :form="form" field="regular_price"></has-error>
                            </div>
                            <div class="form-group">
                                <label>VIP Price</label>
                                <input v-model="form.vip_price" type="number" name="vip_price" placeholder="VIP price"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('vip_price') }">
                                <has-error :form="form" field="vip_price"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Event Date</label>
                                <input v-model="form.event_date" type="date" name="event_date" placeholder="Max. attendees"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('event_date') }">
                                <has-error :form="form" field="event_date"></has-error>
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
            events: [],
            form: new Form(
                {
                id: '',
                event_name: '',
                venue_name: '',
                max_attendees: '',
                regular_price: '',
                vip_price: '',
                event_date: '',
            }),
        }
    },

    methods: {
        
        fetchEvents(){
            if(this.$gate.isAdmin() || this.$gate.isStaff()){
                axios.get("api/events").then(({data}) => (this.events = data.data));
            }
        },

        createEvent(){
            this.$Progress.start();
            this.form.post('api/events').then(() => {
                Fire.$emit('AfterEventCreate');
                $('#addEventModal').modal('hide');
                Toast.fire({
                        icon: 'success',
                        title: 'Event created successfully'
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

        updateEvent(){
            this.$Progress.start();
            this.form.put('api/events/'+this.form.id)
                .then(() => {
                    $('#addEventModal').modal('hide');
                    Toast.fire({
                        icon: 'success',
                        title: 'Event modified successfully'
                        });
                    Fire.$emit('AfterEventCreate');
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

        deleteEvent(id){
            Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete event!'
                    }).then((result) => {
                        //send delete request to server
                        if (result.value) {
                            this.$Progress.start();
                            axios.delete('api/events/'+id)
                                .then(() => {
                                    Toast.fire({
                                        icon: 'success',
                                        title: 'Event deleted successfully'
                                        });
                                    Fire.$emit('AfterEventCreate');
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

        newEventModal(){
            this.editMode = false;
            this.form.reset();
            $('#addEventModal').modal('show');
        },

        editEventModal(event){
            this.editMode = true;
            this.form.reset();
            this.form.fill(event);
            $('#addEventModal').modal('show');
        },
    },

    created(){
        this.fetchEvents();
        Fire.$on('AfterEventCreate', () => {
            this.fetchEvents();
        });
        //Fetch events every 3 seconds
        //setInterval(() => {this.fetchEvents()}, 3000);
    },

}
</script>

<style>

</style>