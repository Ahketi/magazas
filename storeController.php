<?php

namespace Xypp\Store\Controller;

use Flarum\Api\Controller\AbstractCreateController;
use Flarum\Api\Controller\AbstractDeleteController;
use Flarum\Api\Serializer\ForumSerializer;
use Flarum\Discussion\Discussion;
use Flarum\User\User;
use Flarum\Posts\Post;
use Flarum\Http\RequestUtil;
use Xypp\Store\Models\StoreItem;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Flarum\Api\Serializer\PostSerializer;

class StoreController extends AbstractCreateController
{
    protected $serializer = ForumSerializer::class;

    public function create(Request $request)
    {
        // Veriyi al
        $data = $request->getParsedBody();
        
        // Mağaza öğesi oluştur
        $item = StoreItem::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'price' => $data['price'],
            'user_id' => $request->user()->id,
        ]);

        return $item;
    }

    public function delete(Request $request, $id)
    {
        // Ürün bulun
        $item = StoreItem::findOrFail($id);

        // Ürün sadece sahibi tarafından silinebilir
        if ($item->user_id != $request->user()->id) {
            throw new ModelNotFoundException("You cannot delete this item.");
        }

        $item->delete();
    }
}
