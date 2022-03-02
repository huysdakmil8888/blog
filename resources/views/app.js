class Errors{
    constructor() {
        this.errors={}
    }
    get(field){
        if(this.errors[field]){
            return this.errors[field][0]
        }
    }
    add(errors){
        this.errors=errors
    }
}

new Vue({
    el:"#app",
    data:{
        title:'',
        description:'',
        errors:new Errors()
    },
    methods:{
        onsubmit(){
            axios.post('/store',this.$data)
                .then(response=>alert('success'))
                .catch(e=>this.errors.add(e.response.data))
        }
    }
})
