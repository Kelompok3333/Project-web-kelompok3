<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Daftar semua artikel (termasuk yang belum dipublish)
     */
    public function index()
    {
        $articles = Article::with('author:id,name')
            ->latest()
            ->get()
            ->map(fn ($a) => $this->formatArticle($a));

        return response()->json(['data' => $articles]);
    }

    /**
     * Detail satu artikel
     */
    public function show(Article $article)
    {
        return response()->json(['data' => $this->formatArticle($article->load('author:id,name'))]);
    }

    /**
     * Buat artikel baru
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'           => 'required|string|max:255',
            'excerpt'         => 'nullable|string|max:500',
            'content'         => 'required|string',
            'featured_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'is_published'    => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        $data['created_by'] = $request->user()->id;
        $data['slug']       = $this->uniqueSlug($request->title);

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')
                ->store('articles', 'public');
        }

        if (!empty($data['is_published'])) {
            $data['published_at'] = now();
        }

        $article = Article::create($data);

        return response()->json([
            'message' => 'Artikel berhasil dibuat',
            'data'    => $this->formatArticle($article->load('author:id,name')),
        ], 201);
    }

    /**
     * Update artikel
     */
    public function update(Request $request, Article $article)
    {
        $validator = Validator::make($request->all(), [
            'title'           => 'sometimes|required|string|max:255',
            'excerpt'         => 'nullable|string|max:500',
            'content'         => 'sometimes|required|string',
            'featured_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'is_published'    => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        // Ganti slug jika judul berubah
        if ($request->has('title') && $request->title !== $article->title) {
            $data['slug'] = $this->uniqueSlug($request->title, $article->id);
        }

        // Handle upload gambar baru
        if ($request->hasFile('featured_image')) {
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')
                ->store('articles', 'public');
        }

        // Set published_at saat pertama kali dipublish
        if (!empty($data['is_published']) && !$article->is_published) {
            $data['published_at'] = now();
        }

        $article->update($data);

        return response()->json([
            'message' => 'Artikel berhasil diperbarui',
            'data'    => $this->formatArticle($article->fresh(['author:id,name'])),
        ]);
    }

    /**
     * Toggle publish / unpublish artikel
     */
    public function togglePublish(Article $article)
    {
        $article->is_published = !$article->is_published;
        $article->published_at = $article->is_published ? now() : null;
        $article->save();

        $status = $article->is_published ? 'dipublikasikan' : 'disembunyikan';

        return response()->json([
            'message'      => "Artikel berhasil {$status}",
            'is_published' => $article->is_published,
        ]);
    }

    /**
     * Hapus artikel beserta gambarnya
     */
    public function destroy(Article $article)
    {
        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }

        $article->delete();

        return response()->json(['message' => 'Artikel berhasil dihapus']);
    }

    /* ──────────────────────────────────────
       PRIVATE HELPERS
    ────────────────────────────────────── */

    private function formatArticle(Article $article): array
    {
        return [
            'id'             => $article->id,
            'title'          => $article->title,
            'slug'           => $article->slug,
            'excerpt'        => $article->excerpt,
            'content'        => $article->content,
            'featured_image' => $article->featured_image
                ? asset('storage/' . $article->featured_image)
                : null,
            'is_published'   => (bool) $article->is_published,
            'published_at'   => $article->published_at?->toDateTimeString(),
            'view_count'     => $article->view_count ?? 0,
            'author'         => $article->author ? [
                'id'   => $article->author->id,
                'name' => $article->author->name,
            ] : null,
            'created_at'     => $article->created_at?->toDateTimeString(),
        ];
    }

    private function uniqueSlug(string $title, ?int $excludeId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i    = 1;

        while (
            Article::where('slug', $slug)
                ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
                ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
}
