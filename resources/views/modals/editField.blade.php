<div class="modal fade" id="editField" tabindex="-1" role="dialog" aria-labelledby="editFieldTitle" aria-modal="true"
    :class="{ 'show d-block' : modal == 'editField' }" @click="closeModal($event.target)">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form :action="'/api/fields/' + editableField.id" method="POST" class="form" id="editFieldForm" @submit.prevent="editField">
                @csrf
                @method('PATCH')
                <input type="hidden" name="editableFieldId" :value="editableField.id">
                <div class="modal-header">
                    <h5 class="modal-title" id="editFieldTitle">Edit Field</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click.prevent="showModal('')">
                        <span aria-hidden="true">
                            &times;
                        </span>
                    </button>
                </div>
                <div class="modal-body container">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="title">Field Title</label>
                                <input type="text" class="form-control" name="title" placeholder="Field Title"
                                    :value="editableField.title" :class="{ 'border-danger' : errors.includes('title') }">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="type">Field Type</label>
                                <select class="form-control" name="type" :class="{ 'border-danger' : errors.includes('type') }">
                                    <option value="" :selected="editableField.type == ''">Field Type</option>
                                    <option value="date" :selected="editableField.type == 'date'">Date</option>
                                    <option value="number" :selected="editableField.type == 'number'">Number</option>
                                    <option value="string" :selected="editableField.type == 'string'">String</option>
                                    <option value="boolean" :selected="editableField.type == 'boolean'">Boolean</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" :id="'editFieldButton' + editableField.id">
                        Save
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" @click.prevent="showModal('')">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>