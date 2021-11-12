<script>
    Vue.component('treeselect', VueTreeselect.Treeselect);

    new Vue({
        el: '#chart-account',
        data: {
            checked: 'false',
            disabled: true,
            subAccount: null,
            options: []
        },
        methods: {
            changeDisabled: function () {
                this.disabled = this.checked === 'yes';
                console.log(this.checked);
            },
            initSettings: function () {
                let kind_account = document.getElementById('kind_account').value;
                let account_numer = document.getElementById('account_number').value;
                this.disabled = kind_account === 'Y';
                this.checked = kind_account === 'Y' ? 'no' : 'yes'
                this.subAccount = kind_account === 'Y' ? null : account_numer === -1 ? null : account_numer
            },
            async getData() {
                try {
                    let response = await fetch("get-all");
                    this.options = await response.json();
                } catch (error) {
                    console.log(error);
                }
            }
        },
        created() {
            this.getData();
            this.initSettings();
        }
    });
</script>
