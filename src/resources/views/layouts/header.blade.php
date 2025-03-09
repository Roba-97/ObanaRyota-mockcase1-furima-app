<div class="header__search">
	<form class="header__search-form" action="/" method="get">
		<input class="header__search-input" type="text" name="keyword" placeholder="なにをお探しですか？">
		<button class="header__search-btn" type="submit">検索</button>
	</form>
</div>

<nav class="header__nav">
  <ul class="header__nav-list">
		@if( Auth::check() )
		<li class="header__nav-item">
			<form action="/logout" method="post">
				@csrf
				<button class="header__nav-logout" type="submit">ログアウト</button>
			</form>
		</li>
		@else
		<li class="header__nav-item"><a href="/login">ログイン</a></li>
		@endif
		<li class="header__nav-item"><a href="/mypage">マイページ</a></li>
		<li class="header__nav-item header__nav-item--sell"><a href="/sell">出品</a></li>
  </ul>
</nav>