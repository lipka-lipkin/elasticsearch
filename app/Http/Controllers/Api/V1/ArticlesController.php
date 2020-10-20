<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ArticlesElasticResource;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    private $payload = [];
    private $total;
    private $skip;

    public function autocomplete(Request $request){
        $this->payload = $request->only(['per_page', 'page', 'search']);
        array_key_exists('per_page', $this->payload) ?: $this->payload['per_page'] = 25;
        array_key_exists('page', $this->payload) ?: $this->payload['page'] = 1;
        $this->skip = $this->payload['page'] > 1 ? $this->payload['per_page'] * $this->payload['page'] : 0;
        $searchRequestBuilder = Article::boolSearch()
            ->from($this->skip)
            ->size($this->payload['per_page'])
            ->must('match', ['searchable' => mb_strtolower($request->search)])
            ->execute();
        $this->total = $searchRequestBuilder->total();
        return $this->buildPagination($this->mapDataFromElastic($searchRequestBuilder));
    }

    public function index(Request $request){
        $this->payload = $request->only(['per_page', 'page', 'must', 'should', 'sort']);
        array_key_exists('per_page', $this->payload) ?: $this->payload['per_page'] = 25;
        array_key_exists('page', $this->payload) ?: $this->payload['page'] = 1;
        $this->skip = $this->payload['page'] > 1 ? $this->payload['per_page'] * $this->payload['page'] : 0;
        $searchRequestBuilder = Article::boolSearch()
            ->from($this->skip)
            ->size($this->payload['per_page']);
        if ($request->must){
            $searchRequestBuilder->must('match', ['searchable' => (string)$request->must]);
        }else{
            $searchRequestBuilder->must('match_all');
        }
        if ($request->should){
            $searchRequestBuilder->should('term', ['user_id' => (integer)$request->user_id]);
        }
        if ($request->sort){
            $searchRequestBuilder->sort('created_at', $request->sort);
        }
        $result = $searchRequestBuilder->execute();
        $this->total = $result->total();
        return $this->buildPagination($this->mapDataFromElastic($result));
    }

    private function mapDataFromElastic($data){
        return ArticlesElasticResource::collection($data->documents());
    }

    private function buildPagination($data){
        $getParam = http_build_query($this->payload);
        $currentUrl = url()->current();
        $prevPage = $this->payload['page'] - 1;
        $nextPage = $this->payload['page'] + 1;
        $lastPage = max((int) ceil($this->total / $this->payload['per_page']), 1);
        $from = $this->skip = 0 ? $this->skip + 1 : $this->skip;
        $to = $from + $this->payload['per_page'];
        return [
            'data' => $data,
            'links' => [
                'first' => $currentUrl . '?page=1' . $getParam,
                'last' => $currentUrl . '?page=' . $lastPage . $getParam,
                'prev' => $this->payload['page'] > 1 ? null : $currentUrl . '?page=' . $prevPage . $getParam,
                'next' => $currentUrl . '?page=' . $nextPage . $getParam
            ],
            'meta' => [
                'current_page' => (int)$this->payload['page'],
                'from' => $from,
                'last_page' => $lastPage,
                'links' => [],
                'path' => $currentUrl,
                'per_page' => (int)$this->payload['per_page'],
                'to' => $to,
                'total' => $this->total,
            ]
        ];
    }

    public function store(Request $request){
        $article = new Article();
        $article->title = $request->title;
        $article->description = $request->description;
        $article->body = $request->body;
        $article->user_id = $request->user_id;
        $article->tags = $request->tags;
        $article->save();
        return ArticleResource::make($article);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
