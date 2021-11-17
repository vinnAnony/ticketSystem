<template>
  <div class="container mt-4">
      <h3>Upcoming Events</h3>
    <div class="row">

        <div class="col-auto mb-3" v-for="event in events" :key="event.id">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title mr-4">{{event.event_name}}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{event.event_date | systemDate}}</h6>
                    <p class="card-text mb-1">Venue: {{event.venue_name}}</p>
                    <p class="card-text mb-1">Regular Ticket : Ksh.{{event.regular_price}}</p>
                    <p class="card-text mb-1">VIP Ticket : Ksh.{{event.vip_price}}</p>
                    <p class="card-text">Remaining tickets : <span>{{event.remaining_tickets}}</span></p>
                    <div class="d-flex justify-content-center">

                            <a href="#"  @click="bookEventModal(event)">
                                <button class="btn btn-success center">Book</button>
                            </a>
                    </div>
                    
                </div>
            </div>
        </div>
        
    </div>

    <!-- Book event modal -->
    <div class="modal fade" id="bookEventModal" tabindex="-1" role="dialog" aria-labelledby="bookEventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookEventModalLabel">Make Reservation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="bookEvent()">
                    <div class="modal-body">
                        <AlertErrors :form="form" message="There were some problems with your input." />
                        <div class="form-group">
                            <label>Event Name</label>
                            <h5>{{form.event_name}}</h5>
                            <input v-model="form.event_name" type="text" name="event_name" hidden>
                        </div>
                        <div class="form-group">
                            <input v-model="form.id" type="number" name="event_id" hidden>
                        </div>
                        <div class="form-group">
                            <input v-model="currentUserId" type="number" name="user_id" hidden>
                        </div>
                        <div class="form-group">
                            <label>Event Venue</label>
                            <h5>{{form.venue_name}}</h5>
                            <input v-model="form.venue_name" type="text" name="venue_name" hidden>
                        </div>
                        <div class="form-group">
                            <label>Event Date</label>
                            <h5>{{form.event_date | systemDate}}</h5>
                            <input v-model="form.event_date" type="text" name="event_date" hidden>
                        </div>
                        <div class="form-group">
                            <label>Regular Seats</label>
                            <input v-model="form.regular_seats" type="number" name="regular_seats" placeholder="Regular seats"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('regular_seats') }">
                            <has-error :form="form" field="regular_seats"></has-error>
                        </div>
                        <div class="form-group">
                            <label>VIP Seats</label>
                            <input v-model="form.vip_seats" type="number" name="vip_seats" placeholder="VIP seats"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('vip_seats') }">
                            <has-error :form="form" field="vip_seats"></has-error>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button  :disabled="form.busy" type="submit" class="btn btn-success">Book</button>
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
            currentUserId: this.$userId,
            events: [],
            form: new Form({
                id: '',
                user_id: '',
                event_id: '',
                event_name: '',
                venue_name: '',
                regular_seats: '',
                vip_seats: '',
                event_date: '',
            }),
        }
    },

    methods:{
        fetchAllEvents(){
            axios.get("api/events").then(({data}) => (this.events = data.data));
        },

        bookEvent(){
            this.$Progress.start();
            this.form.post('api/reservations').then(() => {
                Fire.$emit('AfterEventBook');
                $('#bookEventModal').modal('hide');
                Toast.fire({
                        icon: 'success',
                        title: 'Reservation made successfully'
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

        bookEventModal(event){
            this.form.reset();

            event.event_id = event.id;
            event.user_id = this.$userId;
            
            this.form.fill(event);
            $('#bookEventModal').modal('show');
        },

    },

    created(){
        this.fetchAllEvents();
        Fire.$on('AfterEventBook', () => {
            this.fetchAllEvents();
        });
        //Fetch events every 3 seconds
        //setInterval(() => {this.fetchAllEvents()}, 3000);
        
        //console.log(this.currentUserId);
    },

}
</script>

<style>

</style>