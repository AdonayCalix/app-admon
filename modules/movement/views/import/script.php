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
            movements: null,
            batch_name: null
        },
        methods: {
            async getMovements() {
                this.getBatchNumber();
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
            async getBatchNumber() {
                try {
                    let response = await fetch("get-batch-info?project_id=" + this.project_id + "&kind=" + this.kind_of_movement_id);
                    this.batch_name = await response.json();
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
            async sendChecks() {
                try {
                    let response = await fetch("get-check-message?project_id=" + this.project_id + '&batch_number=' + this.batch_name);

                    await fetch('https://ceprosaffunctions.azurewebsites.net/api/SendChecks?code=RWYBgLBfsfvWW1Gz1pwwNOUuoJoHceOv5cVyriMtex8EHWFKBnKqkQ==', {
                        method: 'POST',
                        body: JSON.stringify(await response.json())
                    });
                } catch (error) {
                    console.log(error);
                }
            },
            async sendDeposits() {
                try {
                    let response = await fetch("get-deposit-message?project_id=" + this.project_id + '&batch_number=' + this.batch_name);

                    await fetch('https://ceprosaffunctions.azurewebsites.net/api/SendChecks?code=RWYBgLBfsfvWW1Gz1pwwNOUuoJoHceOv5cVyriMtex8EHWFKBnKqkQ==', {
                        method: 'POST',
                        body: JSON.stringify(await response.json())
                    });
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
                    this.sendChecks();
                    //window.location.href = "show-again";
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