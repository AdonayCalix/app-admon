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
                this.subClass = null
            },
            async getData() {
                try {
                    let response = await fetch("get-all");
                    this.options = await response.json();
                } catch (error) {
                    console.log(error);
                }
            },
            async initSettings() {
                let identifier = document.getElementById('identifier').value;
                let kind_class = document.getElementById('kind_class').value;

                this.disabled = kind_class === 'Y';
                this.checked = kind_class === 'Y' ? 'no' : 'yes'
                this.subClass = document.getElementById('last_id').value
                console.log(this.subAccount);
            }
        },
        created() {
            this.initSettings();
            this.getData();
        }
    });
</script>
