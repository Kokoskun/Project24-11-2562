<template>
	<div class="animated fadeIn">
		<div class="card">
			<div class="row">
				<div class="col-md-12 col-xs-12 col-sm-12 text-center mt-3">
					<h4><b>{{title}} <i class="far fa-layer-group"></i></b></h4>
					<p><b>จำนวนข้อมูลในตาราง: </b><span class="badge badge-light">{{table.rows.length}}</span> ข้อมูล</p>
				</div>
				<div class="col-md-12 col-xs-12 col-sm-12">
					<vue-good-table :columns="table.columns" :rows="table.rows" :sort-options="table.options" :search-options="{ enabled: true }">
						<template slot="table-row" slot-scope="props"></template>
					</vue-good-table>
				</div>
			</div>
		</div>
		<v-dialog/>
	</div>
</template>
<script>
import Vue from 'vue'
import VueGoodTablePlugin from 'vue-good-table';
import 'vue-good-table/dist/vue-good-table.css'
import VModal from 'vue-js-modal'
Vue.use(VModal,{dialog:true});
Vue.use(VueGoodTablePlugin);
export default {
	name: 'app',
	data() {
		return {
			title: 'ข้อมูลร้านอาหาร',
			modal: {
				title:'',
				detail:''
			},
			alert: {
				message: ''
			},
			table: {
				rows: [],
				options: {
					enabled: true,
					initialSortBy: {field: 'updated_at', type: 'desc'}
				},
				columns: [{
					label: 'Name',
					field: 'name',
					tdClass: 'text-center',
					thClass: 'text-center',
					filterable: true
				}, {
					label: 'Address',
					field: 'formatted_address',
					tdClass: 'text-center',
					thClass: 'text-center',
					filterable: true
				},{
					label: 'Geometry',
					field: 'geometry',
					tdClass: 'text-center',
					thClass: 'text-center',
					filterable: true
				},{
					label: 'Types',
					field: 'types',
					type: 'number',
					tdClass: 'text-center',
					thClass: 'text-center'
				}]
			}
		}
	},
	async mounted() {
		document.title=process.env.MIX_NAME_VUE+' | '+this.title
		this.sendAPI();
	},
	methods: {
		hide () {
			this.$modal.hide('dialog');
		},
		closeModal() {
			this.hide()
		},
		async sendAPI() {
			try {
				await this.resetLoading(1)
				this.table.rows = []
				const body = (await this.$http.get(process.env.MIX_API_URL + 'api/v1/restaurant')).body
				let value = null, data = [],geometry=null
				if(body.results&&body.results.length>0){
					for(value of body.results){
						if(value.geometry.location&&value.geometry.location.lat&&value.geometry.location.lng){
							geometry=value.geometry.location.lat+' , '+value.geometry.location.lng
						}else{
							geometry='-'
						}
						data.push({
							formatted_address: value.formatted_address,
							name: value.name,
							geometry: geometry,
							types: JSON.stringify(value.types)
						})
					}
				}
				this.table.rows = data
			} catch (error) {
				if (error.body) {
					if (error.body.alert) {
						this.alert.message = error.body.alert
					} else {
						this.alert.message = 'ไม่สามารถเชื่อมต่อกับระบบได้ กรุณาตรวจสอบเครื่อข่าย'
					}
				} else {
					this.alert.message = 'ไม่สามารถเชื่อมต่อกับระบบได้ กรุณาตรวจสอบเครื่อข่าย'
				}
				this.$dialogs.alert(this.alert.message,{title: 'เกิดข้อผิดพลาดในการดึงข้อมูล'})
			}
		}
	}
}
</script>
<style lang="scss">
@import url('https://fonts.googleapis.com/css?family=Kanit:400,700&display=swap&subset=latin-ext,thai,vietnamese');
body{
	font-family: 'Kanit', sans-serif;
}
</style>
