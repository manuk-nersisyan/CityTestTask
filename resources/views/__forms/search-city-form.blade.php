<div class="container">
    <h2>Search form</h2>
    <form action="{{route('search_city')}}">
        <div class="form-group">
            <label for="search">Email:</label>
            <input type="text" class="form-control" id="search" placeholder="Enter city" name="city">
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>
</div>
