<template>
<div>    
    <form @submit.prevent>
        <div class="form-group row">
            <label for="event_name" class="col-sm-4 col-form-label text-success ">Nombre del Evento:</label>
            <div class="col-sm-8">
                <input type="text" id="event_name" class="form-control" v-model="newEvent.event_name" >
            </div>
        </div>
        <div class="form-group row">
            <label for="start_date" class="col-sm-3 col-form-label text-success ">Fecha de Inicio:</label>
                <div class="col-sm-3">
                    <input 
                        type="date"
                        id="start_date"
                        class="form-control"
                        v-model="newEvent.start_date" >
                </div> 
            <label for="start_date" class="col-sm-3 col-form-label text-success ">Fecha Final:</label>
                <div class="col-sm-3">
                    <input 
                        type="date"
                        id="end_date"
                        class="form-control"
                        v-model="newEvent.end_date" >
                </div>
             
        </div>
        <div class="row ">
            
            <div class="col-md-12 mb-4 row justify-content-center" v-if="addingMode">
                <button class="btn btn-sm btn-success" @click="addNewEvent">GUARDAR EVENTO</button>
            </div>
            <template v-else>
                <div class="col-md-6 mb-4">
                    <button class="btn btn-sm btn-success" @click="updateEvent">Actualizar</button>
                    <button class="btn btn-sm btn-danger" @click="deleteEvent">Eliminar</button>
                    <button class="btn btn-sm btn-warning" @click="addingMode = !addingMode">Cancelar</button>
                </div>
            </template>
        </div>
    </form>
    
    <Fullcalendar @eventClick="showEvent" :plugins="calendarPlugins" :events="events"/>
     
</div>
</template>

<script>
    import Fullcalendar from "@fullcalendar/vue";
    import dayGridPlugin from "@fullcalendar/daygrid";
    import interactionPlugin from "@fullcalendar/interaction";

    export default {
        components: {
            Fullcalendar
        },
        data(){
            return {
                calendarPlugins : [dayGridPlugin, interactionPlugin],
                events: "",
                newEvent: {
                    event_name: "",
                    start_date: "",
                    end_date: ""
                },
                addingMode: true,
                indexToUpdate: ""
            }
        },
        created(){
            this.getEvents();
        },
        methods:{
            addNewEvent(){
                axios.post('/api/calendar', {
                    ...this.newEvent
                })
                .then(data => {
                    this.getEvents();
                    this.resetForm();
                })
                .catch(err => 
                    console.log('error del evento', err.response.data)
                );
            },
            showEvent(arg){
                this.addingMode = false;
                const { id, title, start, end } = this.events.find(
                    event => event.id === +arg.event.id   
                );
                this.indexToUpdate = id;
                this.newEvent = {
                    event_name: title,
                    start_date: start,
                    end_date: end
                }
            },
            updateEvent(){
                axios.put('/api/calendar/'+this.indexToUpdate, {
                    ...this.newEvent
                })
                .then(resp => {
                    this.resetForm();
                    this.getEvents();
                    this.addingMode = !this.addingMode;
                })
                .catch(err =>
                    console.log('El vento fue actualizado!', err.response.data)
                );
            },
            deleteEvent(){
                axios.delete('/api/calendar/'+this.indexToUpdate)
                    .then(res => {
                        this.resetForm();
                        this.getEvents();
                        this.addingMode = !this.addingMode;
                    })
                    .catch(err => 
                        console.log('El evento fue eliminado!', err.response.data)
                    );
            },
            getEvents(){
                axios.get('/api/calendar')
                    .then(res => (this.events = res.data.data))
                    .catch(err => console.log(err.response.data));
            },
            resetForm() {
                Object.keys(this.newEvent).forEach(key => {
                    return (this.newEvent[key] = "");
                });
            }
        },
        watch: {
            indexToUpdate() {
                return this.indexToUpdate;
            }
        }
    }
</script>

<style lang="css" >
    @import "~@fullcalendar/core/main.css";
    @import "~@fullcalendar/daygrid/main.css"; 

    .fc-title {
        color: #fff;
    }
    .fc-title hover {
        cursor: pointer;
    }
</style>


