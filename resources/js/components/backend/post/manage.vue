<template>
  <div>
    <div class="card mt-3">
      <!-- <div class="card-header">
          <h1>Category</h1>
      </div> -->

      <div class="card-header">
        <h3 class="card-title">Posts</h3>
        <div class="card-tools">
          <router-link to="/add-post" class="btn btn-info btn-sm"
            >Add Post</router-link
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
              <th>Title</th>
              <th>Thumbnail</th>
              <th>Category Name</th>
              <th>Created By</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(post, index) in getPost">
              <td><input type="checkbox" :value="post.id" v-model="selected"></td>
              <td>{{ ++index }}</td>
              <td> {{ post.title | substring(20)}}... </td>
              <td> <img :src="post.thumbnail" alt="" width="60"></td>
              <td> {{ post.category.name}} </td>
              <td> {{ post.user.name}} </td>
              <td><span class="badge" :class="statusColor(post.status)">{{ post.status | capitalize}}</span></td>
              
              <td style="width: 130px;">
                <router-link :to="`/edit-post/${post.slug}`" class="btn btn-outline-info btn-sm"><i class="fas fa-edit"></i></router-link>
                <button class="btn btn-outline-danger btn-sm" @click = "remove(post.slug)"><i class="fas fa-trash"></i></button>
              </td>
            </tr>

            <tr v-if="!emptyData()">
              <td colspan="7">
                  <div class="dropdown">
                    <button class="btn btn-info dropdown-toggle" :disabled = "!isSelected" type="button" id="dropdownMenu2" data-toggle="dropdown">
                      Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                      <button @click="changeStatus(selected, 'published')" class="dropdown-item" type="button">Published</button>
                      <button @click="changeStatus(selected, 'draft')" class="dropdown-item" type="button">Draft</button>
                      <button @click="removeItems(selected)" class="dropdown-item" type="button">Remove</button>
                    </div>
                  </div>
              </td>
            </tr>

            <tr v-if="emptyData()">
              <td colspan="9">
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
  name: "Managepost",
  created() {},
  data() {
    return {
      // postIds: []
      selected: [],
      isSelected: false,
      selectedAll: false,
    };
  },
  mounted() {
    this.$store.dispatch("getPost");
  },
  computed: {
    getPost() {
      return this.$store.getters.post;
    },
  },

  watch: {
    selected: function (selected){
      this.isSelected = (selected.length > 0);
      this. selectedAll = (selected.length === this.getPost.length);
    }
  },

  methods: {
    statusColor: function(status){
      let data = {draft: "bg-danger", published: "bg-success"}
      return data[status];
    },
    remove: function(slug){
         this.confirm(() => {

           axios.get("remove-post/" + slug).then((result) => {
                this.$store.dispatch("getPost");
                //toastr.success("Category Delete Success");
                Swal.fire(
                'Deleted!',
                'Category has been deleted.',
                'success'
              )
            }).catch((err) => {
            });     
   })      
},

    selectAll: function(event){
      if (event.target.checked == false) {
        this. selected = [];
      }else{
        this.getPost.forEach(post => {
          if (this.selected.indexOf(post.id) === -1) {
            this.selected.push(post.id);
          }
          
        });
      }
    },

  removeItems: function(selected){
    this.confirm(() => {
    axios.post("/posts/remove-items/", {data: selected}).then((result) => {

      this.selected    = [];
      this.isSelected  = false;
      this.selectedAll = false;

      this.$store.dispatch("getPost");
      toastr.success(result.data.total + " Post Delete Success");
    }).catch((err) => {
      
     });
    });
  },

  changeStatus: function(selected, status){

    // let msg = status === 1 ? "Active" : "Inactive";

    axios.post("/posts/change-status/", {data: selected, status: status}).then((result) => {

      this.selected    = [];
      this.isSelected  = false;
      this.selectedAll = false;

      this.$store.dispatch("getPost");
      toastr.success(result.data.total + " Post Successfully " + status);
    }).catch((err) => {
      
    });
  },

    emptyData(){
     return this.getPost.length < 1;
    },
  },
};
</script>

<style lang="scss" scoped></style>
