<x-app-layout-admin>
<div class="container">
    <h3>Edit Section - {{ $section->title }}</h3>
    <form method="POST" action="{{ route('sections.update', $section) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" value="{{ $section->title }}" class="form-control" required />
        </div>
        <div class="mb-3">
            <label>Order</label>
            <input type="number" name="order" value="{{ $section->order }}" class="form-control" />
        </div>
        <button class="btn btn-primary">Update Section</button>
    </form>
</div>
</x-app-layout-admin>
