<script>

    Vue.component('treeselect', VueTreeselect.Treeselect);

    var movement = new Vue({
        el: '#financial-format',
        data: {
            month: null,
            year: null,
            month_list: [],
            year_list: [],
            project_list: [],
            project_id: null
        },
        methods: {

            download: function (event) {
                event.preventDefault();
                window.location.assign("download?project_id=" + this.project_id + "&date=" + this.year + "-" + this.month + "-01");
            },
            async getMonths() {
                try {
                    let response = await fetch("get-months");
                    this.month_list = await response.json();
                } catch (error) {
                    console.log(error);
                }
            },
            async getYears() {
                try {
                    let response = await fetch("get-years");
                    this.year_list = await response.json();
                } catch (error) {
                    console.log(error);
                }
            },
            async getProject() {
                try {
                    let response = await fetch("get-projects");
                    this.project_list = await response.json();
                } catch (error) {
                    console.log(error);
                }
            },
        },
        created() {
            this.getMonths();
            this.getYears();
            this.getProject()
        },
    });
</script>