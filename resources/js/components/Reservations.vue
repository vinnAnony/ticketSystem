<template>
  <div class="row justify-content-center mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                <h3 class="card-title">My Tickets</h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Event Name</th>
                        <th>Venue</th>
                        <th>Event Date</th>
                        <th>Regular Tickets</th>
                        <th>VIP Tickets</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="reservation in reservations" :key="reservation.id">
                        <td>{{reservation.id}}</td>
                        <td>{{reservation.event_name}}</td>
                        <td>{{reservation.venue_name}}</td>
                        <td>{{reservation.event_date | systemDate}}</td>
                        <td>{{reservation.regular_seats}}</td>
                        <td>{{reservation.vip_seats}}</td>
                    </tr>
                    </tbody>
                </table>
                </div>
                <!-- /.card-body -->
            </div>
        <!-- /.card -->
        </div>

    </div>
</template>

<script>
export default {
    data(){
        return{
            reservations: [],
        }
    },

    methods:{
        fetchMyEvents(){
            axios.get("api/reservations/"+this.$userId).then(({data}) => (this.reservations = data.data));
        },

    },

    created(){
        this.fetchMyEvents();
        Fire.$on('AfterEventBook', () => {
            this.fetchMyEvents();
        });
        //Fetch events every 3 seconds
        //setInterval(() => {this.fetchMyEvents()}, 3000);
        
        //console.log(this.currentUserId);
    },

}
</script>

<style>

</style>