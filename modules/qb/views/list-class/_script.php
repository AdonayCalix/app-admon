<script>
    Vue.component('treeselect', VueTreeselect.Treeselect);

    new Vue({
        el: '#list-class',
        data: {
            checked: 'false',
            disabled: true,
            subClass: null,
            options: []
        },
        methods: {
            changeDisabled: function () {
                this.disabled = this.checked === 'yes';
            },
            async getData() {
                try {
                    let response = await fetch("get-all");
                    this.options = await response.json();
                } catch (error) {
                    console.log(error);
                }
            },
            async getSubClass() {
               let identifier = document.getElementById('identifier').value;
                this.subClass = identifier == -1 ? null : identifier;
            }
        },
        created() {
            this.getSubClass();
            this.getData();
        }
    });
</script>
