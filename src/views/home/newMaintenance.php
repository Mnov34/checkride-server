<div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Add new maintenance</h5>
    <button type="button" class="text-white btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>
<div class="offcanvas-body">
    <form method="POST" action="/maintenance/add">
        <div class="row mb-3">
            <div class="col">
                <label class="form-label">Brand
                    <select name="formBrand" class="form-control" required>
                        <option value="">-------</option>
                        <option value="Aprilia">Aprilia</option>
                        <option value="Benelli">Benelli</option>
                        <option value="Beta">Beta</option>
                        <option value="BMW">BMW</option>
                        <option value="Buell">Buell</option>
                        <option value="Cagiva">Cagiva</option>
                        <option value="Can-Am">Can-Am</option>
                        <option value="Ducati">Ducati</option>
                        <option value="Gas Gas">Gas Gas</option>
                        <option value="Harley-Davidson">Harley-Davidson</option>
                        <option value="Honda">Honda</option>
                        <option value="Husaberg">Husaberg</option>
                        <option value="Husqvarna">Husqvarna</option>
                        <option value="Indian">Indian</option>
                        <option value="Kawasaki">Kawasaki</option>
                        <option value="KTM">KTM</option>
                        <option value="Moto Guzzi">Moto Guzzi</option>
                        <option value="MV Agusta">MV Agusta</option>
                        <option value="Norton">Norton</option>
                        <option value="Peugeot">Peugeot</option>
                        <option value="Piaggio">Piaggio</option>
                        <option value="Royal Enfield">Royal Enfield</option>
                        <option value="Sherco">Sherco</option>
                        <option value="Suzuki">Suzuki</option>
                        <option value="Triumph">Triumph</option>
                        <option value="Vespa">Vespa</option>
                        <option value="Victory">Victory</option>
                        <option value="Yamaha">Yamaha</option>
                    </select>
                </label>
            </div>
            <div class="col">
                <label class="form-label">Part
                    <select name="formPart" class="form-control" required>
                        <option value="">-------</option>
                        <option value="Engine oil">Engine oil</option>
                        <option value="Oil filter">Oil filter</option>
                        <option value="Air filter">Air filter</option>
                        <option value="Front tires">Front tires</option>
                        <option value="Back tires">Back tires</option>
                        <option value="Brake pads">Brake pads</option>
                        <option value="Chain">Chain</option>
                        <option value="Spark plug">Spark plug</option>
                        <option value="Chain lubrication">Chain lubrication</option>
                        <option value="Chain tension">Chain tension</option>
                    </select>
                </label>
            </div>
            <div class="col">
                <label class="form-label">Model
                    <input type="text" class="form-control" name="formModel" placeholder="Model" required>
                </label>
            </div>
        </div>
        <div class="col">
            <label class="form-label">Cylinder
                <input type="text" class="form-control" name="formCylinder" placeholder="Cylinder" required>
            </label>
        </div>
        <div class="col">
            <label class="form-label">Year
                <input type="date" class="form-control" name="formYear" required>
            </label>
        </div>
        <div class="col">
            <label class="form-label">Plate
                <input type="text" class="form-control" name="formPlate" placeholder="AA-123-AA" required>
            </label>
        </div>
        <br>
        <div>
            <button type="submit" class="btn btn-primary me-1" name="action">Submit</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Cancel</button>
        </div>
    </form>
</div>