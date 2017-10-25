<div class="alert alert-danger" v-if="errors.any()">
    <p v-for="error in errors.all()">@{{ error }}</p>
</div>

<div class="alert alert-danger" v-else-if="backendErrors.length > 0">
    <p v-for="error in backendErrors">@{{ error }}</p>
</div>

<div class="alert alert-success">
</div>