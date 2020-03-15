<div class="modal fade" id="addField" tabindex="-1" role="dialog" aria-labelledby="addFieldTitle" aria-modal="true"
    :class="{ 'show d-block' : modal == 'addField' }" @click="closeModal($event.target)">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="/api/fields" method="POST" class="form" id="fieldForm" @submit.prevent="addField">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addFieldTitle">Add New Field</h5>
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
                                    :class="{ 'border-danger' : errors.includes('title') }">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="type">Field Type</label>
                                <select class="form-control" name="type" :class="{ 'border-danger' : errors.includes('type') }">
                                    <option value="" selected>Field Type</option>
                                    <option value="date">Date</option>
                                    <option value="number">Number</option>
                                    <option value="string">String</option>
                                    <option value="boolean">Boolean</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="addFieldButton">
                        Create
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" @click.prevent="showModal('')">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>