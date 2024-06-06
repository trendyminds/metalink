<template>
	<div>
		<form class="flex items-center gap-2" @submit.prevent="getMetadata">
			<text-input
				v-model="url"
				class="flex-1"
				placeholder="https://example.com"
			/>
			<button class="btn" type="submit">Fetch</button>
		</form>

		<div class="card text-center py-4 mt-4" v-if="status === 'loading'">
			<p class="text-gray">Loading...</p>
		</div>

		<div class="card text-center py-4 mt-4" v-if="status === 'error'">
			<p>Could not fetch URL. Try again.</p>
		</div>

		<div class="card flex mt-4" v-if="status === 'loaded'" style="gap: 20px">
			<img
				:src="value.image"
				class="object-cover rounded-lg"
				style="height: 158px; width: 300px"
			/>
			<div>
				<h2 v-text="value.title" class="text-sm font-bold"></h2>
				<p v-text="value.description" class="text-xs mt-2 text-gray"></p>
				<button type="button" class="flex btn btn-xs mt-2 gap-2" @click="reset">
					<svg-icon name="eraser" class="h-4" />
					<span>Remove</span>
				</button>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	mixins: [Fieldtype],

	mounted() {
		if (!this.value) {
			this.reset()
		}
	},

	methods: {
		reset() {
			this.status = 'idle'
			this.url = ''
			this.update({
				url: '',
				title: '',
				description: '',
				image: '',
			})
		},

		async getMetadata() {
			this.status = 'loading'

			try {
				const { data } = await this.$axios({
					method: 'POST',
					url: '/!/metalink/metadata',
					data: {
						url: this.url,
					},
				})

				this.update({
					url: data.url,
					title: data.title,
					description: data.description,
					image: data.image,
				})

				this.status = 'loaded'
			} catch (e) {
				this.status = 'error'
			}
		},
	},

	data() {
		return {
			status: this.value?.url ? 'loaded' : 'idle',
			url: this.value?.url || '',
		}
	},
}
</script>
