<template>
    <div>

        <div>
            <div class="row">
                <router-link to="/store-employee" class="btn btn-primary btn-block">Add Employee</router-link>
            </div>
            <br>
            <input v-model="searchTerm" class="form-control"  style="width: 300px;" type="text" placeholder="Search here">
            <br>
        </div>
        <div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Employee List</h6>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Name</th>
                        <th>Photo</th>
                        <th>Phone Number</th>
                        <th>Salary</th>
                        <th>Joining Date</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="employee in filterSearch" :key="employee.id">
                        <td>{{ employee.name }}</td>
                        <td>
                            <img :src="employee.photo" alt="" id="em_photo">
                        </td>
                        <td>{{ employee.phone }}</td>
                        <td>{{ employee.salary }}</td>
                        <td>{{ employee.joining_date }}</td>
                        <td><router-link :to="{name: 'edit-employee', params: {id: employee.id}}" href="#" class="btn btn-sm btn-primary">Edit</router-link>
                            <a @click="deleteEmployee(employee.id)" style="color: white;" class="btn btn-sm btn-danger">Delete</a></td>
                      </tr>

                    </tbody>
                  </table>
                </div>
                <div class="card-footer"></div>
              </div>
            </div>
          </div>
          <!--Row-->

    </div>
</template>

<script>
import axios from 'axios';
export default {
    created() {
        if (!User.loggedIn()) {
            this.$router.push({ name: '/' });
        }
    },
    data(){
        return {
            employees: [],
            searchTerm: ''
        }
    },
    computed: {
        filterSearch(){
            return this.employees.filter(employee => {
                return employee.name.match(this.searchTerm)
            })
        }
    },
    methods:{
        allEmployees(){
            axios.get('/api/employee').then((res)=>{
                this.employees = res.data
            })
        },
        deleteEmployee(id){
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                axios.delete('/api/employee/' + id)
                .then(() =>{
                    this.employees = this.employees.filter(employee=>{
                        return employee.id != id
                    });
                })
                .catch(()=> {
                    this.$router.push({name: 'employee'});
                })
                Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
                )
            }
            })
        }
    },
    mounted(){
        this.allEmployees();
    }

}
</script>

<style>
    #em_photo{
        height: 40px;
        width: 40px;
    }
</style>
