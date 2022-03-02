class Errors{
    constructor() {
        this.errors={}
    }
    get(field){
        if(this.errors[field]){
            return this.errors[field][0]
        }
    }
    record(errors){
        this.errors=errors
    }
    clear(field){
        delete this.errors[field]
    }
    any(){
        return Object.keys(this.errors).length>0
    }
}
class Form{
    constructor(data) {
        this.data=data;
        for(let field in data){
            this[field]=data[field]
        }
        console.log(this.title)
    }
    reset(vm){
        this.title='';
    }
    submit(){

    }
}

new Vue({
    el:"#app",
    data:{
        form: new Form({
            title:'',
            description:''
        }),
        errors:new Errors()
    },
    methods:{
        onsubmit(){
            axios.post('/skill',this.$data)
                .then(this.success)
                .catch(error=>this.errors.record(error.response.data.errors))
        },
        success(response){
          form.reset()
        }
    }
})
