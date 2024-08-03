<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
   <link href="css/font-awesome.min.css" rel="stylesheet" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{asset('front-assets/css/multi-form.css')}}">
   
</head>

<body>
    <div class="container-fluid">
    <h1>Please fill the form carefully..</h1>
    <form action="{{url('add_service')}}" method='POST' class="form" enctype="multipart/form-data">
        @csrf
        <!-- Progress Bar -->
        <div class="progress-bar">
            <div class="progress" id="progress"></div>
            <div class="progress-step active" data-title="Service"></div>
            <div class="progress-step" data-title="Pricing"></div>
            <div class="progress-step" data-title="Description"></div>
            <div class="progress-step" data-title="Gallery"></div>
            <div class="progress-step" data-title="Publish"></div>
           
        </div>

        <!-- Steps -->
        <div class="form-step active">
            <h3>Service Informations</h3>
            <div class="input-group">
                <label for="full-name">Services Title</label>
                <input type="text" name="service_title" id="full-name">
            </div>
            <div class="input-group">
            <label for="full-name">Category</label>
                <select name="category" >
                    @foreach($category as $item)
                    <option value="{{$item->id}}">{{$item->category_name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="input-group">
                <label for="address">Search Tags</label>
               <textarea name="tags" id="" cols="10" rows="5"></textarea>
            </div>
            <div class="">
                <a class="btn btn-next">Next</a>
            </div>
        </div>
        <div class="form-step ">
            <h3>Price Informations</h3>
            <h3>There should be 2 Packeges Max and Min</h3>
            <div class="input-group">
                <label for="email">Max Price</label>
                <input type="text" name="max_price" id="email">
            </div>
            <div class="input-group">
                <label for="phone">Min Price</label>
                <input type="text" name="min_price" id="phone">
            </div>
            <div class="input-group">
                <label for="summary">Max Delivery Time</label>
                <input type="text" name="max_delivery_time" id="phone">
            </div>
            <div class="input-group">
                <label for="summary">Min Delivery Time</label>
                <input type="text" name="min_delivery_time" id="phone">
            </div>
            <div class="btn-group">
                <a class="btn btn-prev">Previous</a>
                <a class="btn btn-next">Next</a>
            </div>
        </div>
        <div class="form-step ">
            <h3>Description</h3>
            <div class="experiences-group">
                <div class="experience-item">
                    <div class="input-group">
                        <label for="title">Services Description</label>
                        <textarea name="desc" id="" cols="30" rows="10"></textarea>
                    </div>

                    <div class="input-group">
                        <label for="title">Add Your Requirements</label>
                        <textarea name="requirement" id="" cols="30" rows="10"></textarea>
                    </div>
                    
                </div>
            </div>
            <div class="add-experience">
                <a class="add-exp-btn" style='display:none'> + Add Experience</a>
            </div>
            <div class="btn-group">
                <a class="btn btn-prev">Previous</a>
                <a class="btn btn-next">Next</a>
            </div>
        </div>
        <div class="form-step ">
            <h3>Gallery</h3>
            <div class="experiences-group">
                <div class="experience-item">
                    <div class="input-group">
                        <label for="title">Add Image</label>
                       <input type="file" name='image'>
                    </div>
                </div>
            </div>
           
            <div class="btn-group">
                <a class="btn btn-prev">Previous</a>
                <a class="btn btn-next">Next</a>
            </div>
       </div>
        <div class="form-step ">
           <h4 style='text-align:center;margin-top:100px'>All set are u sure u wanna submit your service.....</h4>
            
            <div class="btn-group">
                <a class="btn btn-prev">Previous</a>
                <input type="submit" name="complete" class="btn btn-complete">
            </div>
        </div>
    </form>
</div>
    <script src="{{asset('front-assets/js/index.js')}}"></script>
</body>

</html>