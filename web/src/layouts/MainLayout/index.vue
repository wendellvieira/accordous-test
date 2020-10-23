<template>
	<q-layout view="lHh Lpr lFf">
		<q-header elevated>
			<q-toolbar>
				<q-btn
					flat dense round icon="menu"
					aria-label="Menu"
					@click="leftDrawerOpen = !leftDrawerOpen"
				/>

				<q-toolbar-title>
					{{page_name}}
				</q-toolbar-title>

			</q-toolbar>
		</q-header>

		<q-drawer
			v-model="leftDrawerOpen"
			show-if-above
			bordered
			content-class="bg-grey-1"
		>
			<q-list>
				<q-item-label header class="text-grey-8">
					Essential Links
				</q-item-label>

				<EssentialLink
					v-for="link in MapMenu"
					:key="link.title"
					v-bind="link"
				/>

			</q-list>
		</q-drawer>

		<q-page-container>
			<router-view />
		</q-page-container>

	</q-layout>
</template>

<script>
	import EssentialLink from './components/EssentialLink'

	import { MapMenu } from "./settings.js"

	import { mapState } from "vuex"

	export default {
		name: 'MainLayout',

		components: {
			EssentialLink
		},

		computed: {
			...mapState("MAIN_LAYOUT", [
				"page_name"
			])
		},

		data () {
			return {
				leftDrawerOpen: false,
				MapMenu
			}
		}
	}
</script>
