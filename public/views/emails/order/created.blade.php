The order with name: "{{$order->title}}" has been created.
<table>
    <tr>
        <td>Title</td>
        <td>{{$order->title}}</td>
    </tr>
    <tr>
        <td>Author</td>
        <td>{{$order->owner->name}}</td>
    </tr>
    <tr>
        <td>End Date</td>
        <td>{{date('d M Y H:i',$order->date)}}</td>
    </tr>
    <tr>
        <td>Restaurant</td>
        <td>{{$order->restaurant->title}}</td>
    </tr>
    <tr>
        <td>Url</td>
        <td>{{$order->restaurant->url}}</td>
    </tr>
    <tr>
        <td>Description</td>
        <td>{{$order->description}}</td>
    </tr>
    <tr>
        <td>Link</td>
        <td><a target="_blank" href="http://{{$_SERVER['SERVER_NAME']}}/orders/view/{{$irder->id}}">View details</a></td>
    </tr>
</table>
