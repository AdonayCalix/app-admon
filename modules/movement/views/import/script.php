<script>
    Vue.component('treeselect', VueTreeselect.Treeselect);

    var movement = new Vue({
        el: '#import',
        data: {
            kind_of_movement_list: [
                {
                    id: 'Egreso',
                    label: 'Cheques/TB'
                },
                {
                    id: 'Ingreso',
                    label: 'Depositos'
                }
            ],
            kind_of_movement_id: null,
            project_list: [],
            project_id: null,
            movements: null
        },
        methods: {
            async getMovements() {
                if (this.kind_of_movement_id === 'Egreso') this.getChecks();
                if (this.kind_of_movement_id === 'Ingreso') this.getDeposits();
            },
            async getProject() {
                try {
                    let response = await fetch("get-projects");
                    this.project_list = await response.json();
                } catch (error) {
                    console.log(error);
                }
            },
            async getChecks() {
                try {
                    let response = await fetch("get-checks?project_id=" + this.project_id);
                    this.movements = await response.json();
                } catch (error) {
                    console.log(error);
                }
            },
            async getDeposits() {
                try {
                    let response = await fetch("get-deposits?project_id=" + this.project_id);
                    this.movements = await response.json();
                    console.log(this.movements);
                } catch (error) {
                    console.log(error);
                }
            },
            store() {
                $.ajax({
                    url: 'store',
                    method: 'POST',
                    data: $("#w0").serializeArray()
                }).done(data => {
                    console.log(data);
                }).fail(data => {
                    this.errors = $.parseJSON(data.responseText)
                })
            },
            diClick: function (index) {
                let value = document.getElementById(index).checked;
                console.log(value);
                document.getElementById(index).checked = !value;
            }
        },
        created() {
            this.getProject()
        },
    });
</script>