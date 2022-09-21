<script lang="ts">
	import Button from '$lib/Button.svelte'
	import { readableTime, colorHash } from '$lib/utils/formatting'
	import { userState } from '../../../userState'

	let data: Promise<Msg[]>,
		msgContainer: HTMLDivElement,
		sending: object[] = [],
		messageValue = ''
	const loadMsgs = () =>
			(data = fetch(`/api/${$userState.user.id}/messages/${$userState.otherUser.id}`).then((res) =>
				res.json()
			)),
		toggleTime = (id: string) => {
			const classList = document.querySelector('#' + id)?.classList
			classList?.contains('showTime') ? classList?.remove('showTime') : classList?.add('showTime')
		},
		sendMsg = () => {
			const body = {
				content: messageValue.trim()
			}
			messageValue = ''

			fetch(`/api/${$userState.user.id}/messages/${$userState.otherUser.id}`, {
				method: 'POST',
				body: JSON.stringify(body)
			}).then((res) => console.log(res))

			sending.push(body)
			console.log(sending)
		}

	$: if (msgContainer)
		setTimeout(() => {
			msgContainer.scrollTop = msgContainer.scrollHeight
		}, 25)
	$: loadMsgs()
</script>

<svelte:head>
	<title>{$userState.otherUser.first} {$userState.otherUser.last} | Chat | ChatService</title>
	<meta name="description" content="See all the threads you have between your friends." />
	<!-- <meta http-equiv="Content-Security-Policy"
		  content="default-src 'self'; img-src https://*; child-src 'none';"> -->
</svelte:head>

<!-- <div>User info: {JSON.stringify($userState.otherUser)}<br /></div> -->

<div
	class="container test"
	bind:this={msgContainer}
	on:contextmenu|preventDefault={() => loadMsgs()}
>
	{#await data}
		<div class="trueCenter">Loading...</div>
	{:then msgs}
		<div class="scrollContainer">
			{#each msgs.reverse() as msg, id}
				{@const timeSpread =
					new Date(msgs[id - 1]?.posted ?? 0).getTime() / 1000 <
					new Date(msg.posted).getTime() / 1000 - 3600}
				{@const nextTimeSpread =
					new Date(msgs[id + 1]?.posted ?? 0).getTime() / 1000 - 3600 >
					new Date(msg.posted).getTime() / 1000}

				{#if timeSpread}
					<div class="timeSpacer">{readableTime(msg.posted, true)}</div>
				{/if}

				<div
					id={msg.id}
					class="{msg.sender.id === $userState.user.id ? 'outgoing' : 'incoming'} row"
					class:first={msgs[id - 1]?.sender.id !== msg.sender.id || timeSpread}
					class:last={msgs[id + 1]?.sender.id !== msg.sender.id || nextTimeSpread}
					class:showTime={msgs.length === id + 1}
					on:click={() => toggleTime(msg.id)}
				>
					<div class="row">
						<div class="avatar {colorHash(msg.sender.first[0] ?? '_')}">
							{msg.sender.first[0] || '_'}
						</div>
						<div class="column">
							<div class="msg" on:click={() => false}>
								{#if msg.msgType === 'text/plain'}
									{msg.content}
								{:else}
									Unsupported message type
								{/if}
							</div>
							<div class="timestamp">
								{#if msg.sender.id !== $userState.user.id}
									{readableTime(msg.posted, true)}
								{:else if msg.metadata.search(/\d{4}-\d{2}-\d{2}\w\d{2}:\d{2}:\d{2}.\d{3}\w/) >= 0}
									Read •
									{readableTime(
										msg.metadata.match(/\d{4}-\d{2}-\d{2}\w\d{2}:\d{2}:\d{2}.\d{3}\w/)?.[0] ??
											msg.posted,
										true
									)}
								{:else}
									Sent •
									{readableTime(msg.posted, true)}
								{/if}
							</div>
						</div>
					</div>
				</div>

				<!-- <div>{JSON.stringify(msg)}</div> -->
			{:else}
				<div class="trueCenter">No messages found</div>
			{/each}
		</div>
	{:catch err}
		<div class="trueCenter">An error occured <br /> {err}</div>
	{/await}
</div>

<div id="inputOptions">
	<div id="inputContainer" class="row">
		<textarea id="inputMsg" placeholder="Chat message" bind:value={messageValue} />
		<Button
			icon="send"
			classes="minimal"
			style="margin-right: 0;border-radius:50%;padding: 6px;width: 1em;height: 1em;font-size: 2.1em;"
			on:click={() => sendMsg()}
		/>
	</div>
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
		position: relative;
		display: flex;
		flex-direction: column;
		height: 100%;
		max-height: 100%;
		flex-grow: 1;
		justify-content: flex-end;
		overflow: auto;
	}
	.container .scrollContainer {
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		display: flex;
		flex-direction: column;
		min-height: 100%;
		flex-grow: 1;
		justify-content: flex-end;
		padding: 0.25rem 1rem 0;
		box-sizing: border-box;
	}
	.timeSpacer {
		padding: 1rem 0 0.25rem;
		color: #5f6388;
		text-align: center;
		font-size: 0.75rem;
	}
	.incoming,
	.outgoing {
		flex-direction: column;
		align-items: flex-start;
		width: 100%;
		margin-top: 2px;
	}
	.outgoing {
		align-items: flex-end;
	}
	.incoming .row {
		margin-right: 44px;
	}
	.avatar {
		height: 0px;
		min-width: 36px;
		width: 36px;
		margin-inline-end: 0.5rem;
		overflow: hidden;
	}
	.outgoing .avatar {
		display: none;
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
	.outgoing .column {
		display: flex;
		flex-direction: column;
		justify-content: flex-end;
	}
	.msg {
		display: inline-block;
		max-width: 450px;
		padding: 10px 12px;
		border-radius: 4px;
		border-radius: 4px 20px 20px 4px;
		box-shadow: -1px 2px 10px 2px var(--lightShadow);
		background-color: var(--incomingBgColor);
		color: var(--incomingColor);
		font-size: 0.875rem;
		cursor: pointer;
	}
	.first .msg {
		border-top-left-radius: 20px;
	}
	.last .msg {
		border-bottom-left-radius: 20px;
	}
	.outgoing .msg {
		display: inline-block;
		align-self: flex-end;
		border-radius: 20px 4px 4px 20px;
		--outgoingBgColor: #ecfaf5;
		background-color: var(--outgoingBgColor);
		color: var(--outgoingColor);
	}
	.outgoing.first .msg {
		border-top-right-radius: 20px;
	}
	.outgoing.last .msg {
		border-bottom-right-radius: 20px;
	}
	.timestamp {
		height: 0px;
		margin-top: 4px;
		padding: 0 10px;
		overflow: hidden;
		font-size: 0.75rem;
		user-select: none;
		transition: height ease-in-out 50ms;
	}
	.outgoing .timestamp {
		text-align: end;
	}
	:global(.showTime .timestamp) {
		height: 1rem !important;
		overflow: visible;
	}

	#inputOptions {
		padding: 1rem;
	}
	#inputContainer {
		padding: 2px 0.5rem 2px 1rem;
		border-radius: 26px;
		background-color: var(--primaryBackground);
		box-shadow: 0 1px 5px 0 rgba(60, 64, 67, 0.15), 0 4px 4px 0 rgba(60, 64, 67, 0.1),
			0 -0.1px 3px 0 rgba(60, 64, 67, 0.08);
	}
	#inputMsg {
		font: inherit;
		font-size: 0.875rem;
		line-height: 1;

		/* font: 400 14px/20px Roboto,Helvetica Neue,sans-serif,Noto Color Emoji,NotoColorEmoji,apple color emoji,windows emoji,windows symbol; */
		letter-spacing: 0.2px;
		background-color: var(--input-bg-color);
		border: 0;
		box-sizing: border-box;
		color: var(--input-color);
		left: -0.1em;
		/* line-height: var(--line-height,20px); */
		outline: 0;
		overflow-wrap: break-word;
		overflow-x: hidden;
		overflow-y: auto;
		-webkit-overflow-scrolling: touch;
		padding: 13px 0;
		position: relative;
		resize: none;
		white-space: pre-wrap;
		width: 100%;
		word-break: break-word;
		word-wrap: break-word;
		z-index: 1;

		height: 40px;
		overflow-y: hidden;
	}
</style>
