<script>
    var example1 = new Vue({
        el: '#accordionDetail',
        data: {
            items: [
                { mensaje: 'Something' },
            ]
        },
        methods: {
            addDetail: function (event) {
                event.preventDefault();
                this.items.push('moose')
            }
        }
    })
</script>