<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        // Create user
        $admin = $this->createUser(1, 'admin@gmail.com', 'ZAQ!2wsx', \App\Models\User::ROLE_ADMIN);
        $this->createUserMeta($admin->id, \App\Helpers\DataFormat::FORMAT_STRING, 'first_name', 'Super', getLang());
        $this->createUserMeta($admin->id, \App\Helpers\DataFormat::FORMAT_STRING, 'last_name', 'Admin', getLang());

        if(!\Illuminate\Support\Facades\App::environment('prod')) {
            $userRoles = \App\Models\User::getRoles();

            foreach($userRoles as $role) {
                $user = $this->createUser(0, 'user_' . $role . '0@gmail.com', 'Password112233', $role);
                $this->createUserMeta($user->id, \App\Helpers\DataFormat::FORMAT_STRING, 'first_name', 'user0', getLang());
                $this->createUserMeta($user->id, \App\Helpers\DataFormat::FORMAT_STRING, 'last_name', $role, getLang());
                $this->createUserMeta($user->id, \App\Helpers\DataFormat::FORMAT_STRING, 'full_name', 'user0 ' . $role, getLang());

                $user = $this->createUser(1, 'user_' . $role . '1@gmail.com', 'Password112233', $role);
                $this->createUserMeta($user->id, \App\Helpers\DataFormat::FORMAT_STRING, 'first_name', 'user1', getLang());
                $this->createUserMeta($user->id, \App\Helpers\DataFormat::FORMAT_STRING, 'last_name', $role, getLang());
                $this->createUserMeta($user->id, \App\Helpers\DataFormat::FORMAT_STRING, 'full_name', 'user1 ' . $role, getLang());

                if($role == \App\Models\User::ROLE_ADMIN) {
                    $this->createUserPermission($user->id, 'setting', 1, 1, 1, 1, 0);
                }

                $this->createUserPermission($user->id, 'post', 1, 1, 1, 1, 0);
                $this->createUserPermission($user->id, 'category', 1, 1, 1, 1, 0);
            }
        }

        // Create setting
        $this->createSetting($admin->id, \App\Helpers\DataFormat::FORMAT_BOOL,      'indexing',     \App\Helpers\DataFormat::toString(false, \App\Helpers\DataFormat::FORMAT_BOOL), '');
        $this->createSetting($admin->id, \App\Helpers\DataFormat::FORMAT_STRING,    'description',  \App\Helpers\DataFormat::toString('Website description', \App\Helpers\DataFormat::FORMAT_STRING), getLang());
        $this->createSetting($admin->id, \App\Helpers\DataFormat::FORMAT_STRING,    'keywords',     \App\Helpers\DataFormat::toString('store,website', \App\Helpers\DataFormat::FORMAT_STRING), getLang());
        $this->createSetting($admin->id, \App\Helpers\DataFormat::FORMAT_INT,       'favicon',      \App\Helpers\DataFormat::toString(0, \App\Helpers\DataFormat::FORMAT_INT), '');
        $this->createSetting($admin->id, \App\Helpers\DataFormat::FORMAT_STRING,    'title',        \App\Helpers\DataFormat::toString('Store crm', \App\Helpers\DataFormat::FORMAT_STRING), getLang());
        $this->createSetting($admin->id, \App\Helpers\DataFormat::FORMAT_INT,       'logo',         \App\Helpers\DataFormat::toString(0, \App\Helpers\DataFormat::FORMAT_INT), '');
        $this->createSetting($admin->id, \App\Helpers\DataFormat::FORMAT_INT,       'status',       \App\Helpers\DataFormat::toString(1, \App\Helpers\DataFormat::FORMAT_INT), '');

        // Create types
        $postTypes = $this->getPostTypes();
        foreach ($postTypes as $typeKey => $typeItem) {
            $childOfItem = isset($postTypes[$typeItem['child_of']]) ? $postTypes[$typeItem['child_of']]['item']->id : 0;
            $currentType = $this->createType($admin->id, $typeItem['status'], $typeItem['title'], $typeItem['name'], $typeItem['type'], $typeItem['has_parent'], $childOfItem);
            $postTypes[$typeKey]['item'] = $currentType;
            $ordering = 0;
            foreach($typeItem['metas'] as $metaKey => $metaItem) {
                $ordering++;
                $this->createTypeMeta(
                    $admin->id, $currentType->id,
                    $metaItem['label'], $metaItem['name'], $metaItem['field_type'], '{}', '', $metaItem['required'], $metaItem['default_value'], $metaItem['label'], $metaItem['tab'], 1, $ordering);
            }
        }

        // Create Category
        $postCategory = $postTypes[2];
        $categoryNews = $this->createCategory($admin->id, 0, 1, '0', 0, $postCategory['item']->id);
        $this->createRoute($categoryNews->id, 'news', $postCategory['item']->id);
        $newsMeta = [
            'parent' => ['format' => \App\Helpers\DataFormat::FORMAT_INT],
            'title' => ['format' => \App\Helpers\DataFormat::FORMAT_STRING, 'value' => 'News'],
            'status' => ['format' => \App\Helpers\DataFormat::FORMAT_BOOL],
            'content' => ['format' => \App\Helpers\DataFormat::FORMAT_STRING, 'value' => 'News Content'],
            'url' => ['format' => \App\Helpers\DataFormat::FORMAT_STRING, 'value' => 'news'],
            'thumbnail' => ['format' => \App\Helpers\DataFormat::FORMAT_INT],
            'keyword' => ['format' => \App\Helpers\DataFormat::FORMAT_STRING],
            'description' => ['format' => \App\Helpers\DataFormat::FORMAT_STRING],
        ];

        foreach($postCategory['metas'] as $item) {
            $newsFormat = isset($newsMeta[$item['name']]) && isset($newsMeta[$item['name']]['format']) ? $newsMeta[$item['name']]['format'] : \App\Helpers\DataFormat::FORMAT_STRING;
            $newsValue = isset($newsMeta[$item['name']]) && isset($newsMeta[$item['name']]['value']) ? $newsMeta[$item['name']]['value'] : $item['default_value'];
            $this->createCategoryMeta($admin->id, $categoryNews->id, $newsFormat, $item['name'], $newsValue, getLang());
        }

        // Create Post
        $post = $postTypes[3];
        $news1 = $this->createPost($admin->id, $categoryNews->id, 0, 1, '1', 0, $post['item']->id);
        $this->createRoute($news1->id, 'news1', $post['item']->id);
        $newsMeta = [
            'parent' => ['format' => \App\Helpers\DataFormat::FORMAT_INT],
            'title' => ['format' => \App\Helpers\DataFormat::FORMAT_STRING, 'value' => 'News 1'],
            'status' => ['format' => \App\Helpers\DataFormat::FORMAT_BOOL],
            'content' => ['format' => \App\Helpers\DataFormat::FORMAT_STRING, 'value' => 'News 1 Content 1111111'],
            'url' => ['format' => \App\Helpers\DataFormat::FORMAT_STRING, 'value' => 'news1'],
            'thumbnail' => ['format' => \App\Helpers\DataFormat::FORMAT_INT],
            'keyword' => ['format' => \App\Helpers\DataFormat::FORMAT_STRING],
            'description' => ['format' => \App\Helpers\DataFormat::FORMAT_STRING],
        ];

        foreach($post['metas'] as $item) {
            $newsFormat = isset($newsMeta[$item['name']]) && isset($newsMeta[$item['name']]['format']) ? $newsMeta[$item['name']]['format'] : \App\Helpers\DataFormat::FORMAT_STRING;
            $newsValue = isset($newsMeta[$item['name']]) && isset($newsMeta[$item['name']]['value']) ? $newsMeta[$item['name']]['value'] : $item['default_value'];
            $this->createPostMeta($admin->id, $news1->id, $newsFormat, $item['name'], $newsValue, getLang());
        }

        $news2 = $this->createPost($admin->id, $categoryNews->id, 0, 1, '1', 0, $post['item']->id);
        $this->createRoute($news2->id, 'news2', $post['item']->id);
        $newsMeta = [
            'parent' => ['format' => \App\Helpers\DataFormat::FORMAT_INT],
            'title' => ['format' => \App\Helpers\DataFormat::FORMAT_STRING, 'value' => 'News 2'],
            'status' => ['format' => \App\Helpers\DataFormat::FORMAT_BOOL],
            'content' => ['format' => \App\Helpers\DataFormat::FORMAT_STRING, 'value' => 'News 2 Content 2222222'],
            'url' => ['format' => \App\Helpers\DataFormat::FORMAT_STRING, 'value' => 'news2'],
            'thumbnail' => ['format' => \App\Helpers\DataFormat::FORMAT_INT],
            'keyword' => ['format' => \App\Helpers\DataFormat::FORMAT_STRING],
            'description' => ['format' => \App\Helpers\DataFormat::FORMAT_STRING],
        ];

        foreach($post['metas'] as $item) {
            $newsFormat = isset($newsMeta[$item['name']]) && isset($newsMeta[$item['name']]['format']) ? $newsMeta[$item['name']]['format'] : \App\Helpers\DataFormat::FORMAT_STRING;
            $newsValue = isset($newsMeta[$item['name']]) && isset($newsMeta[$item['name']]['value']) ? $newsMeta[$item['name']]['value'] : $item['default_value'];
            $this->createPostMeta($admin->id, $news2->id, $newsFormat, $item['name'], $newsValue, getLang());
        }

        $page = $postTypes[1];
        $about = $this->createPost($admin->id, 0, 0, 1, '0', 0, $page['item']->id);
        $this->createRoute($about->id, 'about', $page['item']->id);
        $newsMeta = [
            'parent' => ['format' => \App\Helpers\DataFormat::FORMAT_INT],
            'title' => ['format' => \App\Helpers\DataFormat::FORMAT_STRING, 'value' => 'About'],
            'status' => ['format' => \App\Helpers\DataFormat::FORMAT_BOOL],
            'content' => ['format' => \App\Helpers\DataFormat::FORMAT_STRING, 'value' => 'About content'],
            'url' => ['format' => \App\Helpers\DataFormat::FORMAT_STRING, 'value' => 'about'],
            'thumbnail' => ['format' => \App\Helpers\DataFormat::FORMAT_INT],
            'keyword' => ['format' => \App\Helpers\DataFormat::FORMAT_STRING],
            'description' => ['format' => \App\Helpers\DataFormat::FORMAT_STRING],
        ];

        foreach($page['metas'] as $item) {
            $newsFormat = isset($newsMeta[$item['name']]) && isset($newsMeta[$item['name']]['format']) ? $newsMeta[$item['name']]['format'] : \App\Helpers\DataFormat::FORMAT_STRING;
            $newsValue = isset($newsMeta[$item['name']]) && isset($newsMeta[$item['name']]['value']) ? $newsMeta[$item['name']]['value'] : $item['default_value'];
            $this->createPostMeta($admin->id, $about->id, $newsFormat, $item['name'], $newsValue, getLang());
        }

    }

    private function createRoute($parentId, $name, $typeId)
    {
        return \App\Models\Route::create([
            'parent_id' => $parentId,
            'name' => $name,
            'type_id' => $typeId
        ]);
    }
    private function createUserPermission($userId, $accessAction, $actionCreate, $actionRead, $actionUpdate, $actionDelete, $onlyOwn)
    {
        return \App\Models\UserPermission::create([
            'user_id'       => $userId,
            'access_action' => $accessAction,
            'action_create' => $actionCreate,
            'action_read'   => $actionRead,
            'action_update' => $actionUpdate,
            'action_delete' => $actionDelete,
            'only_own'      => $onlyOwn
        ]);
    }
    private function createCategory($userId, $templateId, $status, $step, $parentId, $typeId)
    {
        return \App\Models\Category::create([
            'user_id'       => $userId,
            'template_id'   => $templateId,
            'status'        => $status,
            'step'          => $step,
            'parent_id'     => $parentId,
            'type_id'       => $typeId
        ]);
    }
    private function createCategoryMeta($userId, $parentId, $metaFormat, $metaKey, $metaValue, $lang)
    {
        return \App\Models\CategoryMeta::create([
            'user_id'       => $userId,
            'parent_id'     => $parentId,
            'meta_format'   => $metaFormat,
            'meta_key'      => $metaKey,
            'meta_value'    => $metaValue,
            'lang'          => $lang
        ]);
    }
    private function createPost($userId, $categoryId, $templateId, $status, $step, $parentId, $typeId)
    {
        return \App\Models\Post::create([
            'user_id'       => $userId,
            'category_id'   => $categoryId,
            'template_id'   => $templateId,
            'status'        => $status,
            'step'          => $step,
            'parent_id'     => $parentId,
            'type_id'       => $typeId
        ]);
    }
    private function createPostMeta($userId, $parentId, $metaFormat, $metaKey, $metaValue, $lang)
    {
        return \App\Models\PostMeta::create([
            'user_id'       => $userId,
            'parent_id'     => $parentId,
            'meta_format'   => $metaFormat,
            'meta_key'      => $metaKey,
            'meta_value'    => $metaValue,
            'lang'          => $lang
        ]);
    }
    private function createUser($status, $email, $password, $role)
    {
        return \App\Models\User::create([
            'status'        => $status,
            'email'         => $email,
            'password'      => $password,
            'role'          => $role
        ]);
    }
    private function createUserMeta($userId, $format, $metaKey, $metaValue, $lang)
    {
        return \App\Models\UserMeta::create([
            'user_id'       => $userId,
            'meta_format'   => $format,
            'meta_key'      => $metaKey,
            'meta_value'    => $metaValue,
            'lang'          => $lang
        ]);
    }
    private function createSetting($userId, $metaFormat, $metaKey, $metaValue, $lang)
    {
        return \App\Models\Setting::create([
            'user_id'       => $userId,
            'meta_key'      => $metaKey,
            'meta_value'    => $metaValue,
            'meta_format'   => $metaFormat,
            'lang'          => $lang
        ]);
    }
    private function createType($userId, $status, $title, $name, $type, $hasParent, $childOf)
    {
        return \App\Models\Type::create([
            'user_id'       => $userId,
            'status'        => $status,
            'title'         => $title,
            'name'          => $name,
            'type'          => $type,
            'has_parent'    => $hasParent,
            'child_of'      => $childOf
        ]);
    }
    private function createTypeMeta($userId, $typeId, $label, $name, $fieldType, $fieldParams, $description, $required, $defaultValue, $placeholder, $tab, $blocked, $ordering)
    {
        return \App\Models\TypeMeta::create([
            'user_id'       => $userId,
            'type_id'       => $typeId,
            'label'         => $label,
            'name'          => $name,
            'field_type'    => $fieldType,
            'field_params'  => $fieldParams,
            'description'   => $description,
            'required'      => $required,
            'default_value' => $defaultValue,
            'placeholder'   => $placeholder,
            'tab'           => $tab,
            'active'        => $blocked,
            'ordering'      => $ordering
        ]);
    }
    private function getPostTypes()
    {
        return [
            1 => [
                'title' => 'Page',
                'name' => 'page',
                'status' => '1',
                'type' => 'post',
                'has_parent' => '1',
                'child_of' => '0',
                'metas' => [
                    ['label' => 'Parent',       'name' => 'parent',         'field_type' => 'select',       'required' => '0', 'default_value' => '0',  'tab' => 'main'],
                    ['label' => 'Title',        'name' => 'title',          'field_type' => 'text',         'required' => '1', 'default_value' => '',   'tab' => 'main'],
                    ['label' => 'Status',       'name' => 'status',         'field_type' => 'truefalse',    'required' => '0', 'default_value' => '1',  'tab' => 'main'],
                    ['label' => 'Content',      'name' => 'content',        'field_type' => 'editor',       'required' => '0', 'default_value' => '',   'tab' => 'main'],
                    ['label' => 'Url',          'name' => 'url',            'field_type' => 'text',         'required' => '1', 'default_value' => '',   'tab' => 'fields'],
                    ['label' => 'Thumbnail',    'name' => 'thumbnail',      'field_type' => 'image',        'required' => '0', 'default_value' => '',   'tab' => 'fields'],
                    ['label' => 'Keyword',      'name' => 'keyword',        'field_type' => 'text',         'required' => '0', 'default_value' => '',   'tab' => 'seo'],
                    ['label' => 'Description',  'name' => 'description',    'field_type' => 'text',         'required' => '0', 'default_value' => '',   'tab' => 'seo']
                ]
            ],
            2 => [
                'title' => 'Post Category',
                'name' => 'post_category',
                'status' => '1',
                'type' => 'category',
                'has_parent' => '1',
                'child_of' => '0',
                'metas' => [
                    ['label' => 'Parent',       'name' => 'parent',         'field_type' => 'select',       'required' => '0', 'default_value' => '0',  'tab' => 'main'],
                    ['label' => 'Title',        'name' => 'title',          'field_type' => 'text',         'required' => '1', 'default_value' => '',   'tab' => 'main'],
                    ['label' => 'Status',       'name' => 'status',         'field_type' => 'truefalse',    'required' => '0', 'default_value' => '1',  'tab' => 'main'],
                    ['label' => 'Content',      'name' => 'content',        'field_type' => 'editor',       'required' => '0', 'default_value' => '',   'tab' => 'main'],
                    ['label' => 'Url',          'name' => 'url',            'field_type' => 'text',         'required' => '1', 'default_value' => '',   'tab' => 'fields'],
                    ['label' => 'Thumbnail',    'name' => 'thumbnail',      'field_type' => 'image',        'required' => '0', 'default_value' => '',   'tab' => 'fields'],
                    ['label' => 'Keyword',      'name' => 'keyword',        'field_type' => 'text',         'required' => '0', 'default_value' => '',   'tab' => 'seo'],
                    ['label' => 'Description',  'name' => 'description',    'field_type' => 'text',         'required' => '0', 'default_value' => '',   'tab' => 'seo']
                ]
            ],
            3 => [
                'title' => 'Post',
                'name' => 'post',
                'status' => '1',
                'type' => 'post',
                'has_parent' => '0',
                'child_of' => '2',
                'metas' => [
                    ['label' => 'Category',     'name' => 'category',       'field_type' => 'select',       'required' => '0', 'default_value' => '0',  'tab' => 'main'],
                    ['label' => 'Title',        'name' => 'title',          'field_type' => 'text',         'required' => '1', 'default_value' => '',   'tab' => 'main'],
                    ['label' => 'Status',       'name' => 'status',         'field_type' => 'truefalse',    'required' => '0', 'default_value' => '1',  'tab' => 'main'],
                    ['label' => 'Content',      'name' => 'content',        'field_type' => 'editor',       'required' => '0', 'default_value' => '',   'tab' => 'main'],
                    ['label' => 'Url',          'name' => 'url',            'field_type' => 'text',         'required' => '1', 'default_value' => '',   'tab' => 'fields'],
                    ['label' => 'Thumbnail',    'name' => 'thumbnail',      'field_type' => 'image',        'required' => '0', 'default_value' => '',   'tab' => 'fields'],
                    ['label' => 'Keyword',      'name' => 'keyword',        'field_type' => 'text',         'required' => '0', 'default_value' => '',   'tab' => 'seo'],
                    ['label' => 'Description',  'name' => 'description',    'field_type' => 'text',         'required' => '0', 'default_value' => '',   'tab' => 'seo']
                ]
            ],
            4 => [
                'title' => 'Goods Category',
                'name' => 'goods_category',
                'status' => '0',
                'type' => 'category',
                'has_parent' => '1',
                'child_of' => '0',
                'metas' => [
                    ['label' => 'Parent',       'name' => 'parent',         'field_type' => 'select',       'required' => '0', 'default_value' => '0',  'tab' => 'main'],
                    ['label' => 'Title',        'name' => 'title',          'field_type' => 'text',         'required' => '1', 'default_value' => '',   'tab' => 'main'],
                    ['label' => 'Status',       'name' => 'status',         'field_type' => 'truefalse',    'required' => '0', 'default_value' => '1',  'tab' => 'main'],
                    ['label' => 'Content',      'name' => 'content',        'field_type' => 'editor',       'required' => '0', 'default_value' => '',   'tab' => 'main'],
                    ['label' => 'Url',          'name' => 'url',            'field_type' => 'text',         'required' => '1', 'default_value' => '',   'tab' => 'fields'],
                    ['label' => 'Thumbnail',    'name' => 'thumbnail',      'field_type' => 'image',        'required' => '0', 'default_value' => '',   'tab' => 'fields'],
                    ['label' => 'Keyword',      'name' => 'keyword',        'field_type' => 'text',         'required' => '0', 'default_value' => '',   'tab' => 'seo'],
                    ['label' => 'Description',  'name' => 'description',    'field_type' => 'text',         'required' => '0', 'default_value' => '',   'tab' => 'seo']
                ]
            ],
            5 => [
                'title' => 'Goods',
                'name' => 'goods',
                'status' => '0',
                'type' => 'post',
                'has_parent' => '0',
                'child_of' => '4',
                'metas' => [
                    ['label' => 'Category',     'name' => 'category',       'field_type' => 'select',       'required' => '0', 'default_value' => '0',  'tab' => 'main'],
                    ['label' => 'Title',        'name' => 'title',          'field_type' => 'text',         'required' => '1', 'default_value' => '',   'tab' => 'main'],
                    ['label' => 'Status',       'name' => 'status',         'field_type' => 'truefalse',    'required' => '0', 'default_value' => '1',  'tab' => 'main'],
                    ['label' => 'Content',      'name' => 'content',        'field_type' => 'editor',       'required' => '0', 'default_value' => '',   'tab' => 'main'],
                    ['label' => 'Url',          'name' => 'url',            'field_type' => 'text',         'required' => '1', 'default_value' => '',   'tab' => 'fields'],
                    ['label' => 'Thumbnail',    'name' => 'thumbnail',      'field_type' => 'image',        'required' => '0', 'default_value' => '',   'tab' => 'fields'],
                    ['label' => 'Keyword',      'name' => 'keyword',        'field_type' => 'text',         'required' => '0', 'default_value' => '',   'tab' => 'seo'],
                    ['label' => 'Price',        'name' => 'price',          'field_type' => 'text',         'required' => '0', 'default_value' => '0',  'tab' => 'fields'],
                    ['label' => 'Description',  'name' => 'description',    'field_type' => 'text',         'required' => '0', 'default_value' => '',   'tab' => 'seo']
                ]
            ],
            6 => [
                'title' => 'Service Category',
                'name' => 'service_category',
                'status' => '0',
                'type' => 'category',
                'has_parent' => '1',
                'child_of' => '0',
                'metas' => [
                    ['label' => 'Parent',       'name' => 'parent',         'field_type' => 'select',       'required' => '0', 'default_value' => '0',  'tab' => 'main'],
                    ['label' => 'Title',        'name' => 'title',          'field_type' => 'text',         'required' => '1', 'default_value' => '',   'tab' => 'main'],
                    ['label' => 'Status',       'name' => 'status',         'field_type' => 'truefalse',    'required' => '0', 'default_value' => '1',  'tab' => 'main'],
                    ['label' => 'Content',      'name' => 'content',        'field_type' => 'editor',       'required' => '0', 'default_value' => '',   'tab' => 'main'],
                    ['label' => 'Url',          'name' => 'url',            'field_type' => 'text',         'required' => '1', 'default_value' => '',   'tab' => 'fields'],
                    ['label' => 'Thumbnail',    'name' => 'thumbnail',      'field_type' => 'image',        'required' => '0', 'default_value' => '',   'tab' => 'fields'],
                    ['label' => 'Keyword',      'name' => 'keyword',        'field_type' => 'text',         'required' => '0', 'default_value' => '',   'tab' => 'seo'],
                    ['label' => 'Description',  'name' => 'description',    'field_type' => 'text',         'required' => '0', 'default_value' => '',   'tab' => 'seo']
                ]
            ],
            7 => [
                'title' => 'Service',
                'name' => 'service',
                'status' => '0',
                'type' => 'post',
                'has_parent' => '0',
                'child_of' => '6',
                'metas' => [
                    ['label' => 'Category',     'name' => 'category',       'field_type' => 'select',       'required' => '0', 'default_value' => '0',  'tab' => 'main'],
                    ['label' => 'Title',        'name' => 'title',          'field_type' => 'text',         'required' => '1', 'default_value' => '',   'tab' => 'main'],
                    ['label' => 'Status',       'name' => 'status',         'field_type' => 'truefalse',    'required' => '0', 'default_value' => '1',  'tab' => 'main'],
                    ['label' => 'Content',      'name' => 'content',        'field_type' => 'editor',       'required' => '0', 'default_value' => '',   'tab' => 'main'],
                    ['label' => 'Url',          'name' => 'url',            'field_type' => 'text',         'required' => '1', 'default_value' => '',   'tab' => 'fields'],
                    ['label' => 'Thumbnail',    'name' => 'thumbnail',      'field_type' => 'image',        'required' => '0', 'default_value' => '',   'tab' => 'fields'],
                    ['label' => 'Keyword',      'name' => 'keyword',        'field_type' => 'text',         'required' => '0', 'default_value' => '',   'tab' => 'seo'],
                    ['label' => 'Price',        'name' => 'price',          'field_type' => 'text',         'required' => '0', 'default_value' => '0',  'tab' => 'fields'],
                    ['label' => 'Description',  'name' => 'description',    'field_type' => 'text',         'required' => '0', 'default_value' => '',   'tab' => 'seo']
                ]
            ]
        ];
    }
}
