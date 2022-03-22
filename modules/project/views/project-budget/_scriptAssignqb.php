<script>
    Vue.component('treeselect', VueTreeselect.Treeselect);

    var assign = new Vue({
        el: '#assign-qb',
        data: {
            project_id: null,
            budget_options: [],
            categories: [],
            class_options: [],
            chart_account_options: []
        },
        methods: {
            initSettings: function () {
                this.budget_options.push({
                    id: document.getElementById('budget_id').value,
                    label: document.getElementById('budget_name').value
                });
            },
            async getClassOptions() {
                try {
                    let response = await fetch("get-all-classes");
                    this.class_options = await response.json();
                } catch (error) {
                    console.log(error);
                }
            },
            async getAccountOptions() {
                try {
                    let response = await fetch("get-all-accounts");
                    this.chart_account_options = await response.json();
                } catch (error) {
                    console.log(error);
                }
            },
            async getData() {
                try {
                    let response = await fetch("get-all-categories-only?id=" + this.budget_options[0].id);
                    this.categories = await response.json();
                } catch (error) {
                    console.log(error);
                }
            },
        },
        created() {
            this.initSettings();
            this.getClassOptions();
            this.getAccountOptions();
            this.getData();
        }
    });
</script>