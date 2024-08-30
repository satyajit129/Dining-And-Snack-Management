<form id="manpowerFormUpdate">
    @csrf
    <input type="hidden" name="id" value="{{ $manpower->id }}">
    <x-select name="shift_id" class="form-control" id="shift_id" label="Shift">
        <option selected disabled>Select Shift</option>
        @foreach ($shifts as $shift)
            <option value="{{ $shift->id }}" {{ $manpower->shift_id == $shift->id ? 'selected' : '' }}>
                {{ $shift->name }}
            </option>
        @endforeach
    </x-select>
    <x-input type="number" id="count" name="count" value="{{ $manpower->count }}" placeholder="Enter your count"
        label="Count" />
    <button type="submit" id="UpdateManpower" class="btn btn-sm  btn-primary">Save changes</button>
</form>
