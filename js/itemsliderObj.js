class Itemslider {
    static id = 0;
    
    body = '';
    constructor(titel) {
        this.body = `<div class="card">
        <img src="https://images.unsplash.com/photo-1561154464-82e9adf32764?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=800&q=60" height="150px" class="card-img-top" alt="...">
        <div class="card-body">
        <div>   
            <div><input type="checkbox" name="" id="">ist aktiv</div>
            <div><h5 class="card-title">${titel}</h5></div>
      
        </br>`;
        // this.id = this.constructor.id++;
        this.id = this.constructor.id++;
    }
}