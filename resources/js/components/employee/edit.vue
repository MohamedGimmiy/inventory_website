<template>
    <div>

        <div>
            <div class="row">
                <router-link to="/employee" class="btn btn-primary btn-block">All Employee</router-link>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Employee Update</h1>
                                    </div>

                                    <form class="user" @submit.prevent="employeeUpdate" enctype="multipart/form-data">

                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <input v-model="form.name" type="text" class="form-control"
                                                        id="exampleInputFirstName" placeholder="Enter Your Full Name">
                                                        <small v-if="errors.name" class="text-danger">{{ errors.name[0] }}</small>

                                                    </div>
                                                <div class="col-md-6">
                                                    <input v-model="form.email" type="text" class="form-control"
                                                        id="exampleInputFirstName" placeholder="Enter Your email">
                                                        <small v-if="errors.email" class="text-danger">{{ errors.email[0] }}</small>

                                                    </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <input v-model="form.address" type="text" class="form-control"
                                                        id="exampleInputFirstName" placeholder="Enter Your Adderss">
                                                        <small v-if="errors.address" class="text-danger">{{ errors.address[0] }}</small>

                                                    </div>
                                                <div class="col-md-6">
                                                    <input v-model="form.salary" type="text" class="form-control"
                                                        id="exampleInputFirstName" placeholder="Enter Your Salary">
                                                        <small v-if="errors.salary" class="text-danger">{{ errors.salary[0] }}</small>

                                                    </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <input v-model="form.joining_date" type="date" class="form-control"
                                                        id="exampleInputFirstName" placeholder="Enter Your Joining date">
                                                        <small v-if="errors.joining_date" class="text-danger">{{ errors.joining_date[0] }}</small>

                                                    </div>
                                                <div class="col-md-6">
                                                    <input v-model="form.nid" type="text" class="form-control"
                                                        id="exampleInputFirstName" placeholder="Enter Your Nid">
                                                        <small v-if="errors.nid" class="text-danger">{{ errors.nid[0] }}</small>
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <input v-model="form.phone" type="text" class="form-control"
                                                        id="exampleInputFirstName" placeholder="Enter Your phone">
                                                        <small v-if="errors.phone" class="text-danger">{{ errors.phone[0] }}</small>

                                                    </div>

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-6">

                                                    <input @change="onFileSelected" type="file" class="custom-file-input" id="customFile">
                                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                                    <small v-if="errors.photo" class="text-danger">{{ errors.photo[0] }}</small>

                                                </div>
                                                <div class="col-md-6">
                                                    <img :src="form.photo" alt="" style="height: 40px; width: 40px;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Update</button>
                                        </div>
                                        <hr>
                                    </form>
                                    <div class="text-center">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import axios from 'axios';
import Notif from '../../helpers/Notif';

export default {
    created() {
        if (!User.loggedIn()) {
            this.$router.push({ name: '/' });
        }
    },
    data() {
        return {
            form: {
                name: '',
                email: '',
                phone: '',
                salary: '',
                address: '',
                photo: '',
                newPhoto: '',
                nid: '',
                joining_date: '',
            },
            errors: {}
        }
    },
    created(){
        let id = this.$route.params.id;
        axios.get('/api/employee/'+id)
        .then(res=> {
            this.form = res.data
        })
        .catch(err=> console.log(err));
    },
    methods:{
        employeeUpdate(){
            let id = this.$route.params.id;
            axios.patch('/api/employee/'+id,this.form).then(()=>{
                this.$router.push({name: 'employee'})
                Notif.success();
            })
            .catch(error =>this.errors = error.response.data.errors);
        },
        onFileSelected(event){
            let file = event.target.files[0];
            if(file.size > 1048770){
                Notif.image_validation()
            } else{
                let reader = new FileReader();
                reader.onload = event => {
                    this.form.newPhoto = event.target.result
                };
                reader.readAsDataURL(file);
            }
        }
    }

}
</script>

<style></style>
