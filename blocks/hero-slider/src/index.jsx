import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { 
	InspectorControls,
	MediaUpload,
	MediaUploadCheck
} from '@wordpress/block-editor';
import {
	PanelBody,
	TextControl,
	Button,
	RangeControl,
	Icon,
	Notice
} from '@wordpress/components';
import { useState } from '@wordpress/element';
import metadata from '../block.json';

registerBlockType( metadata.name, {
	edit: ( { attributes, setAttributes } ) => {
		const { slides, desktopHeight, mobileHeight, autoplayDelay } = attributes;

		const updateSlide = ( index, key, value ) => {
			const newSlides = [ ...slides ];
			newSlides[ index ][ key ] = value;
			setAttributes( { slides: newSlides } );
		};

		const addSlide = () => {
			setAttributes( {
				slides: [
					...slides,
					{
						id: Date.now().toString(),
						desktopImageId: 0,
						desktopImageUrl: '',
						mobileImageId: 0,
						mobileImageUrl: '',
						linkUrl: '',
						altText: ''
					}
				]
			} );
		};

		const removeSlide = ( index ) => {
			const newSlides = [ ...slides ];
			newSlides.splice( index, 1 );
			setAttributes( { slides: newSlides } );
		};

		const moveSlide = ( index, direction ) => {
			if (
				( direction === 'up' && index === 0 ) ||
				( direction === 'down' && index === slides.length - 1 )
			) {
				return;
			}
			const newSlides = [ ...slides ];
			const targetIndex = direction === 'up' ? index - 1 : index + 1;
			const temp = newSlides[ index ];
			newSlides[ index ] = newSlides[ targetIndex ];
			newSlides[ targetIndex ] = temp;
			setAttributes( { slides: newSlides } );
		};

		return (
			<div className="pooki-hero-slider-editor">
				<InspectorControls>
					<PanelBody title={ __( 'Slider Settings', 'pooki' ) }>
						<TextControl
							label={ __( 'Desktop Height (e.g. 600px, 100vh)', 'pooki' ) }
							value={ desktopHeight }
							onChange={ ( val ) => setAttributes( { desktopHeight: val } ) }
						/>
						<TextControl
							label={ __( 'Mobile Height (e.g. 400px, 80vh)', 'pooki' ) }
							value={ mobileHeight }
							onChange={ ( val ) => setAttributes( { mobileHeight: val } ) }
						/>
						<RangeControl
							label={ __( 'Autoplay Delay (ms)', 'pooki' ) }
							value={ autoplayDelay }
							onChange={ ( val ) => setAttributes( { autoplayDelay: val } ) }
							min={ 1000 }
							max={ 10000 }
							step={ 500 }
						/>
					</PanelBody>
				</InspectorControls>

				<div style={{ padding: '20px', background: '#f0f0f0', border: '1px solid #ccc' }}>
					<h3 style={{ marginTop: 0 }}>{ __( 'Hero Slider Slides', 'pooki' ) }</h3>
					
					{ slides.length === 0 && (
						<Notice status="warning" isDismissible={ false }>
							{ __( 'No slides added yet. Click "Add Slide" to begin.', 'pooki' ) }
						</Notice>
					) }

					{ slides.map( ( slide, index ) => (
						<div key={ slide.id } style={{ background: '#fff', padding: '15px', marginBottom: '15px', border: '1px solid #ddd' }}>
							<div style={{ display: 'flex', justifyContent: 'space-between', marginBottom: '10px' }}>
								<strong>{ __( 'Slide', 'pooki' ) } { index + 1 }</strong>
								<div>
									<Button 
										isSmall
										disabled={ index === 0 }
										onClick={ () => moveSlide( index, 'up' ) }
									>
										&uarr;
									</Button>
									<Button 
										isSmall
										disabled={ index === slides.length - 1 }
										onClick={ () => moveSlide( index, 'down' ) }
										style={{ marginLeft: '5px' }}
									>
										&darr;
									</Button>
									<Button 
										isSmall 
										isDestructive
										onClick={ () => removeSlide( index ) }
										style={{ marginLeft: '10px' }}
									>
										{ __( 'Remove', 'pooki' ) }
									</Button>
								</div>
							</div>

							<div style={{ display: 'flex', gap: '15px', marginBottom: '15px' }}>
								<div style={{ flex: 1 }}>
									<p style={{ margin: '0 0 5px 0' }}><strong>{ __( 'Desktop Image', 'pooki' ) }</strong></p>
									<MediaUploadCheck>
										<MediaUpload
											onSelect={ ( media ) => {
												updateSlide( index, 'desktopImageId', media.id );
												updateSlide( index, 'desktopImageUrl', media.url );
												if( !slide.altText && media.alt ) {
													updateSlide( index, 'altText', media.alt );
												}
											} }
											allowedTypes={ [ 'image' ] }
											value={ slide.desktopImageId }
											render={ ( { open } ) => (
												<div onClick={ open } style={{ cursor: 'pointer', background: '#eee', height: '100px', display: 'flex', alignItems: 'center', justifyContent: 'center', overflow: 'hidden' }}>
													{ slide.desktopImageUrl ? (
														<img src={ slide.desktopImageUrl } style={{ maxWidth: '100%', maxHeight: '100%' }} />
													) : (
														<Button isSecondary>{ __( 'Select Desktop Image', 'pooki' ) }</Button>
													) }
												</div>
											) }
										/>
									</MediaUploadCheck>
								</div>
								
								<div style={{ flex: 1 }}>
									<p style={{ margin: '0 0 5px 0' }}><strong>{ __( 'Mobile Image', 'pooki' ) }</strong></p>
									<MediaUploadCheck>
										<MediaUpload
											onSelect={ ( media ) => {
												updateSlide( index, 'mobileImageId', media.id );
												updateSlide( index, 'mobileImageUrl', media.url );
											} }
											allowedTypes={ [ 'image' ] }
											value={ slide.mobileImageId }
											render={ ( { open } ) => (
												<div onClick={ open } style={{ cursor: 'pointer', background: '#eee', height: '100px', display: 'flex', alignItems: 'center', justifyContent: 'center', overflow: 'hidden' }}>
													{ slide.mobileImageUrl ? (
														<img src={ slide.mobileImageUrl } style={{ maxWidth: '100%', maxHeight: '100%' }} />
													) : (
														<Button isSecondary>{ __( 'Select Mobile Image', 'pooki' ) }</Button>
													) }
												</div>
											) }
										/>
									</MediaUploadCheck>
								</div>
							</div>

							<TextControl
								label={ __( 'Link URL (optional)', 'pooki' ) }
								value={ slide.linkUrl }
								onChange={ ( val ) => updateSlide( index, 'linkUrl', val ) }
							/>
							<TextControl
								label={ __( 'Alt Text', 'pooki' ) }
								value={ slide.altText }
								onChange={ ( val ) => updateSlide( index, 'altText', val ) }
							/>
						</div>
					) ) }

					<Button isPrimary onClick={ addSlide }>
						{ __( 'Add Slide', 'pooki' ) }
					</Button>
				</div>
			</div>
		);
	},
	save: () => {
		// Render in PHP via render.php
		return null;
	},
} );
