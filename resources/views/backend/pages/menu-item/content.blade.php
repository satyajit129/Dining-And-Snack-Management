<form id="menuItemFormUpdate">
    @csrf
    <input type="hidden" name="id" value="{{ $menu_item->id }}">
    
    <x-select name="menu_id" class="form-control" id="menu_id" label="Menu">
        <option selected disabled>Select Menu</option>
        @foreach ($menus as $menu)
            <option value="{{ $menu->id }}" {{ $menu_item->menu_id == $menu->id ? 'selected' : '' }}>
                {{ $menu->type }}
            </option>
        @endforeach
    </x-select>
    
    <x-input type="text" id="item_name" name="item_name" value="{{ $menu_item->item_name }}" placeholder="Item Name"
        label="Item Name" />
    
    <div class="form-group col-md-12 mb-4">
        <label class="text-dark font-weight-medium" for="">Quantity Per Person
            <span class="text-danger">(If the quantity count is in grams, please check the checkbox)</span>
        </label>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <label class="control control-checkbox d-inline-block mb-0">
                        <input id="in_grams" type="checkbox" name="in_grams" value="2" {{ $menu_item->in_grams == '2' ? 'checked' : '' }} />
                        <div class="control-indicator"></div>
                    </label>
                </div>
            </div>
            <input id="quantity_per_person" name="quantity_per_person" type="text" class="form-control"
                aria-label="Text input with checkbox" value="{{ $menu_item->quantity_per_person }}">
        </div>
    </div>
    <x-select name="menu_assignment" class="form-control" id="menu_assignment" label="Menu Assignment">
        <option selected disabled>Select Menu Assignment</option>
        <option value="1" {{ $menu_item->menu_assignment == '1' ? 'selected' : '' }}>Daily</option>
        <option value="2" {{ $menu_item->menu_assignment == '2' ? 'selected' : '' }}>Weekly</option>
        
    </x-select>
    
    <button type="submit" id="UpdateMenuItem" class="btn btn-sm btn-primary">Save changes</button>
</form>

