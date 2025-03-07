<div class="header__search">
	<form action="" class="header__search-form">
		<input class="header__search-input" type="text" placeholder="なにをお探しですか？">
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
		<li class="header__nav-item"><a href="">マイページ</a></li>
		<li class="header__nav-item header__nav-item--sell"><a href="">出品</a></li>
  </ul>
</nav>