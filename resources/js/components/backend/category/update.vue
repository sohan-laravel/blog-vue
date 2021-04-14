<template>
  <div>
    <div class="card mt-3">
      <!-- <div class="card-header">
          <h1>Category</h1>
      </div> -->

          <div class="card-header">
            <h3 class="card-title">Update Category</h3>
            <div class="card-tools">
              <router-link to="/categories" class="btn btn-info btn-sm">Manage Categories</router-link>
            </div>
          </div>
         
          <form method="post" @submit.prevent="updateCategory">
            <div class="card-body">
              
              <div class="form-group">
                <label class="col-sm-3" for="name">Name</label>
                <div class="col-sm-9">
                   <input type="text" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" id="name" v-model="form.name" placeholder="Category Name">
                   <has-error :form="form" field="name"></has-error>
                </div>
              </div>

              <label class="col-sm-3" for="status">Status</label>
              <div class="col-sm-9">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" v-model="form.status" id="active" value="1">
                  <label class="form-check-label" for="active">Active</label>
                </div>

                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" v-model="form.status" id="inactive" value="0">
                  <label class="form-check-label"  for="inactive">Inactive</label>
                  
                </div>

                <span :class="{ 'is-invalid': form.errors.has('status') }"></span>
                   <has-error :form="form" field="status"></has-error>
                
               </div>
              
              <!-- <div class="form-group">
                <label for="exampleInputFile">File input</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="exampleInputFile">
                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                  </div>
                  <div class="input-group-append">
                    <span class="input-group-text">Upload</span>
                  </div>
                </div>
              </div> -->

            </div>
            

            <div class="card-footer">
              <button type="submit" :disabled="form.busy" class="btn btn-primary">Update</button>
              <button type="reset" class="btn btn-default float-right">Reset</button>
            </div>
        </form>
          

      </div>            
  </div>
</template>

<script>
export default {
  name: "CreateCategories",
  created() {},
  data: function(){
    return {
      form: new Form({
        id: null,
        name: null,
        status: null,
      })
    }
  },
  mounted() {
    this.getCategory();
  },
  methods: {
    updateCategory: function(){
      let this_ = this;
      this.form.post('/update-category')
      .then(function(data){
        //   Toast.fire({
        //   icon: 'success',
        //   title: 'Category Created successfully!!..'
        // });

        toastr.success('Success!', 'Category Updated successfully!!..', {"closeButton": true,"progressBar": true,})
        this_.$router.push("/categories");
      });
    },
    getCategory: function(){
      const this_ = this;
                 axios.get("/show-categories/" + this.$route.params.slug).then((result) => {
                
                this_.form.fill(result.data.category);
            }).catch((err) => {
            });
    },
  },
};
</script>

<style lang="scss" scoped></style>