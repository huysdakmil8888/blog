const axios = require('axios');
// import axios from 'axios';
new Vue({
    el:"#app",
    mounted() {
        axios.get('/skill').then(response => this.skill.push(response.data))
    },
    data:{
        skill:['haha']
    }
})
