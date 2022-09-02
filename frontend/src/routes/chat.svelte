<script lang="ts">
	import { userState } from '../userState'

	let data: Msg[] | Promise<Msg[]> = []
	const loadMsgs = () => (data = fetch('messages_unique.json').then((res) => res.json()))
	const colorHash = (seed: string): string => {
		let colorCode = 0
		for (const letter of seed) {
			if (letter) colorCode += letter.charCodeAt(0) * 2
		}
		return 'avatarColor_' + (colorCode % 11).toString()
	}

	$: loadMsgs()
</script>

<!-- <div>User info: {JSON.stringify($userState.otherUser)}<br /></div> -->

<div class="container" on:dblclick={() => loadMsgs()}>
	{#await data}
		<div class="trueCenter" style="margin-top: 38vh;">Loading...</div>
	{:then msgs}
		{#each msgs as msg, id}
			<div 
				class="{msg.sender.id === $userState.user.id ? 'outgoing' : 'incoming'} row"
				class:first={msgs[id - 1]?.sender.id !== msg.sender.id}
				class:last={msgs[id + 1]?.sender.id !== msg.sender.id}
			>
				<div class="avatar {colorHash(msg.sender.first[0] ?? '_')}">{msg.sender.first[0] || '_'}</div>
				<div
					class="msg"
					on:click={() => false}
				>
					{#if msg.msgType === 'text/plain'}
						{msg.content}
					{:else}
						Invalid message type
					{/if}
				</div>
			</div>

			<!-- <div>{JSON.stringify(msg)}</div> -->
		{:else}
			<!-- <div class="trueCenter">No threads, start chatting</div> -->
			No messages
		{/each}
	{:catch err}
		<div class="trueCenter">An error occured | {err}</div>
	{/await}
</div>

<style>
	:root {
		--edgePadding: 2.5rem;
		--defaultText: #202124;
		--disabledText: #94a2a8;
		--secondaryText: #5f6368;
		--primaryBackground: #fff;
		--hover: #f5f6f7;
		--primary: #2b56c6;
		--darkShadow: none;
		--lightShadow: 0 2px 6px 0 rgba(60, 64, 67, 0.15);

		--incomingBgColor: #f2f2f2;
		--incomingColor: var(--defaultText);
		--outgoingBgColor: #ecf3fe;
		--outgoingColor: var(--defaultText);
	}
	.container {
		display: flex;
		flex-direction: column;
		padding: 1rem;
	}
	.incoming, .outgoing {
		align-self: flex-start;
		margin-top: 4px;
	}
	.outgoing {
		align-self: flex-end;
	}
	.avatar {
		height: 0px;
		width: 36px;
		margin-inline-end: .5rem;
		overflow: hidden;
	}
	.incoming.last .avatar {
		height: 36px;
		border-radius: 50%;
		background-color: var(--incomingBgColor);
		color: #fff;
		font-size: 20px;
		line-height: 36px;
		text-align: center;
		text-transform: uppercase;
	}
	.incoming.last .avatar.avatarColor_0 {
		background-color: #ee675c;
		background-color: #007aff;
	}
	.incoming.last .avatar.avatarColor_1 {
		background-color: #fcc934;
		background-color: #ffcc00;
	}
	.incoming.last .avatar.avatarColor_2 {
		background-color: #1a73e8;
		background-color: #32ade6;
	}
	.incoming.last .avatar.avatarColor_3 {
		background-color: #af5cf7;
		background-color: #00c7be;
	}
	.incoming.last .avatar.avatarColor_4 {
		background-color: #4ecde6;
		background-color: #30b0c7;
	}
	.incoming.last .avatar.avatarColor_5 {
		background-color: #5bb974;
		background-color: #34c759;
	}
	.incoming.last .avatar.avatarColor_6 {
		background-color: #fa903e;
		background-color: #ff9500;
	}
	.incoming.last .avatar.avatarColor_7 {
		background-color: #ff63b8;
		background-color: #ff2d55;
	}
	.incoming.last .avatar.avatarColor_8 {
		background-color: #af5cf7;
		background-color: #af52de;
	}
	.incoming.last .avatar.avatarColor_9 {
		background-color: #1967d2;
		background-color: #5856d6;
	}
	.incoming.last .avatar.avatarColor_10 {
		background-color: #b52480;
		background-color: #a2845e;
	}
	.incoming.last .avatar.spam {
		background-color: #d93025;
		background-color: #ff3037;
		color: #f1f3f4;
		fill: #f1f3f4;
	}
	.incoming.last .avatar.blocked {
		color: #5f6368;
		fill: #5f6368;
	}
	.msg {
		max-width: 450px;
		padding: 10px 12px;
		border-radius: 4px;
		border-radius: 0px 20px 20px 0px;
		box-shadow: -1px 2px 10px 2px var(--lightShadow);
		background-color: var(--incomingBgColor);
		color: var(--incomingColor);
		font-size: 0.875rem;
	}
	.first .msg {
		border-top-left-radius: 20px;
	}
	.last .msg {
		border-bottom-left-radius: 20px;
	}
	.outgoing .msg {
		border-radius: 20px 0px 0px 20px;
		background-color: var(--outgoingBgColor);
		color: var(--outgoingColor);
	}
	.outgoing.first .msg {
		border-top-right-radius: 20px;
	}
	.outgoing.last .msg {
		border-bottom-right-radius: 20px;
	}
</style>
