<template>
  <div>
    <div class="card mt-3">
      <!-- <div class="card-header">
          <h1>Category</h1>
      </div> -->

      <div class="card-header">
        <h3 class="card-title">Categories</h3>
        <div class="card-tools">
          <router-link to="/add-category" class="btn btn-info btn-sm"
            >Add Category</router-link
          >
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>
                <input :disabled = "emptyData()" type="checkbox" @click="selectAll" v-model="selectedAll">
              </th>
              <th>SL NO</th>
              <th>Category Name</th>
              <th>Slug</th>
              <th>Status</th>
              <th>Created At</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(category, index) in getCategories">
              <td><input type="checkbox" :value="category.id" v-model="selected"></td>
              <td>{{ ++index }}</td>
              <td>{{ category.name }}</td>
              <td>{{ category.slug }}</td>
              <td><span class="badge" :class="statusColor(category.status)">{{ statusName(category.status) }}</span></td>
              <td>{{ category.created_at | time }}</td>
              <td>
                <router-link :to="`/edit-category/${category.slug}`" class="btn btn-outline-info btn-sm"><i class="fas fa-edit"></i></router-link>
                <button class="btn btn-outline-danger btn-sm" @click = "remove(category.slug)"><i class="fas fa-trash"></i></button>
              </td>
            </tr>

            <tr v-if="!emptyData()">
              <td colspan="7">
                  <div class="dropdown">
                    <button class="btn btn-info dropdown-toggle" :disabled = "!isSelected" type="button" id="dropdownMenu2" data-toggle="dropdown">
                      Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                      <button @click="changeStatus(selected, 1)" class="dropdown-item" type="button">Activator</button>
                      <button @click="changeStatus(selected, 0)" class="dropdown-item" type="button">Inactivator</button>
                      <button @click="removeItems(selected)" class="dropdown-item" type="button">Remove</button>
                    </div>
                  </div>
              </td>
            </tr>

             <tr v-if="emptyData()">
              <td colspan="7">
                <h5 class="text-center text-danger"><b>Data Not Found!..</b></h5>
              </td>
            </tr>

          </tbody>
        </table>
      </div>

      <!-- /.card-body -->
      <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0 float-right">
          <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
          <li class="page-item"><a class="page-link" href="#">1</a></li>
          <li class="page-item"><a class="page-link" href="#">2</a></li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ManageCategories",
  created() {},
  data() {
    return {
      selected: [],
      isSelected: false,
      selectedAll: false,
    };
  },
  mounted() {
    this.$store.dispatch("getCategories");
  },
  computed: {
    getCategories() {
      return this.$store.getters.categories;
    },
  },

  watch: {
    selected: function (selected){
      this.isSelected = (selected.length > 0);
      this. selectedAll = (selected.length === this.getCategories.length);
    }
  },

  methods: {
    statusName: function(status){
      let data = {0: "Inactive", 1: "Active"}
      return data[status];
    },
    statusColor: function(status){
      let data = {0: "bg-danger", 1: "bg-success"}
      return data[status];
    },
    remove: function(slug){
      this.confirm(() => {
        axios.get("remove-categories/" + slug).then((result) => {

          this.$store.dispatch("getCategories");
          //toastr.success("Category Delete Success");
           Swal.fire(
              'Deleted!',
              'Category has been deleted.',
              'success'
           )
          }).catch((err) => {
       });
      });
         
    },

    emptyData(){
     return this.getCategories.length < 1;
    },

    selectAll: function(event){
      if (event.target.checked == false) {
        this. selected = [];
      }else{
        this.getCategories.forEach(category => {
          if (this.selected.indexOf(category.id) === -1) {
            this.selected.push(category.id);
          }
          
        });
      }
    },

  removeItems: function(selected){
    this.confirm(() => {
    axios.post("/categories/remove-items/", {data: selected}).then((result) => {

      this.selected    = [];
      this.isSelected  = false;
      this.selectedAll = false;

      this.$store.dispatch("getCategories");
      toastr.success(result.data.total + " Category Delete Success");
    }).catch((err) => {
      
     });
    });
  },

  changeStatus: function(selected, status){

    let msg = status === 1 ? "Active" : "Inactive";

    axios.post("/categories/change-status/", {data: selected, status: status}).then((result) => {

      this.selected    = [];
      this.isSelected  = false;
      this.selectedAll = false;

      this.$store.dispatch("getCategories");
      toastr.success(result.data.total + " Category Successfully " + msg);
    }).catch((err) => {
      
    });
  }

  },
};
</script>

<style lang="scss" scoped></style>
