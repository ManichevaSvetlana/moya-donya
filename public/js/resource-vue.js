Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('content');

new Vue({
    el: '#app',
    data: {
        resource: '<? echo $resource ?>',
        resources: {},
        newResource: {name: ''},
        updatedResource: {id: '', name: ''}
    },
    mounted: function () {
        this.fetchResources();
    },

    methods: {
        fetchResources: function () {
            this.$http.get('/' + this.resource + '/create').then(function (response) {
                this.resources = response.body;
            })
        },
        destroyResource: function (id) {
            this.$http.delete('/' + this.resource + '/' + id).then(function (response) {
                this.fetchResources();
                alert(response.body);
            })
        },
        storeResource: function () {
            this.$http.post('/' + this.resource, this.newResource).then(function (response) {
                this.fetchResources();
                this.newResource = {name: ''};
                alert(response.body);
            })
        },
        editResource: function (resource) {
            /**Open form for editing resource*/
            document.getElementById('store-button').className += ' non-visible';
            document.getElementById('update-button').className = 'btn btn-warning';
            /**End*/
            this.updatedResource = {id: resource.id, name: resource.name};
        },
        updateResource: function (id) {
            this.$http.put('/' + this.resource + '/' + id, this.newResource).then(function (response) {
                this.fetchResources();
                alert(response.body);
            });
            this.newResource = {name: ''};
            this.updatedResource = {id: '', name: ''};
            /**Close form for editing resource*/
            document.getElementById('update-button').className += ' non-visible';
            document.getElementById('store-button').className = 'btn btn-primary';
            /**End*/
        }
    }
});