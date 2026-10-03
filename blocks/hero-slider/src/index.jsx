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
		const { slides, desktopAspectRatio, mobileAspectRatio, autoplayDelay, arrowColor, paginationColor } = attributes;
		const [ activeSlide, setActiveSlide ] = useState( null );

		const updateSlide = ( index, key, value ) => {
			const newSlides = [ ...slides ];
			newSlides[ index ][ key ] = value;
			setAttributes( { slides: newSlides } );
		};

		const addSlide = () => {
			const newSlides = [
				...slides,
				{
					id: Date.now().toString(),
					imageId: 0,
					imageUrl: '',
					linkUrl: '',
					altText: ''
				}
			];
			setAttributes( { slides: newSlides } );
			setActiveSlide( newSlides.length - 1 );
		};

		const removeSlide = ( index ) => {
			const newSlides = [ ...slides ];
			newSlides.splice( index, 1 );
			setAttributes( { slides: newSlides } );
			if ( activeSlide === index ) setActiveSlide( null );
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
			setActiveSlide( targetIndex );
		};

		return (
			<div className="pooki-hero-slider-editor">
				<InspectorControls>
					<PanelBody title={ __( 'Slider Settings', 'pooki' ) }>
						<TextControl
							label={ __( 'Desktop Aspect Ratio (e.g. 21/9, 16/9, auto)', 'pooki' ) }
							value={ desktopAspectRatio }
							onChange={ ( val ) => setAttributes( { desktopAspectRatio: val } ) }
						/>
						<TextControl
							label={ __( 'Mobile Aspect Ratio (e.g. 1/1, 4/3, auto)', 'pooki' ) }
							value={ mobileAspectRatio }
							onChange={ ( val ) => setAttributes( { mobileAspectRatio: val } ) }
						/>
						<RangeControl
							label={ __( 'Autoplay Delay (ms)', 'pooki' ) }
							value={ autoplayDelay }
							onChange={ ( val ) => setAttributes( { autoplayDelay: val } ) }
							min={ 1000 }
							max={ 10000 }
							step={ 500 }
						/>
						<TextControl
							label={ __( 'Arrows Color', 'pooki' ) }
							value={ arrowColor }
							onChange={ ( val ) => setAttributes( { arrowColor: val } ) }
						/>
						<TextControl
							label={ __( 'Pagination Color', 'pooki' ) }
							value={ paginationColor }
							onChange={ ( val ) => setAttributes( { paginationColor: val } ) }
						/>
					</PanelBody>
				</InspectorControls>

				<div style={{ padding: '20px', background: '#f9fafb', border: '1px solid #e5e7eb', borderRadius: '8px' }}>
					<div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '20px' }}>
						<h3 style={{ margin: 0, fontSize: '18px', fontWeight: 'bold' }}>{ __( 'Hero Slider', 'pooki' ) }</h3>
						<Button isPrimary onClick={ addSlide }>
							{ __( 'Add New Slide', 'pooki' ) }
						</Button>
					</div>
					
					{ slides.length === 0 && (
						<Notice status="info" isDismissible={ false }>
							{ __( 'No slides added yet. Click "Add New Slide" to begin.', 'pooki' ) }
						</Notice>
					) }

					{ slides.map( ( slide, index ) => {
						const isActive = activeSlide === index;
						return (
							<div key={ slide.id } style={{ background: '#fff', marginBottom: '10px', border: '1px solid #e5e7eb', borderRadius: '6px', overflow: 'hidden' }}>
								<div 
									style={{ padding: '12px 15px', display: 'flex', justifyContent: 'space-between', alignItems: 'center', cursor: 'pointer', background: isActive ? '#f3f4f6' : '#fff', borderBottom: isActive ? '1px solid #e5e7eb' : 'none' }}
									onClick={ () => setActiveSlide( isActive ? null : index ) }
								>
									<div style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
										<strong style={{ fontSize: '14px' }}>{ __( 'Slide', 'pooki' ) } { index + 1 }</strong>
										{ slide.imageUrl && <img src={ slide.imageUrl } style={{ width: '40px', height: '24px', objectFit: 'cover', borderRadius: '4px' }} /> }
									</div>
									<div style={{ display: 'flex', gap: '4px' }} onClick={ e => e.stopPropagation() }>
										<Button isSmall disabled={ index === 0 } onClick={ () => moveSlide( index, 'up' ) }>{ __( 'Up', 'pooki' ) }</Button>
										<Button isSmall disabled={ index === slides.length - 1 } onClick={ () => moveSlide( index, 'down' ) }>{ __( 'Down', 'pooki' ) }</Button>
										<Button isSmall isDestructive onClick={ () => removeSlide( index ) }>{ __( 'Remove', 'pooki' ) }</Button>
									</div>
								</div>

								{ isActive && (
									<div style={{ padding: '20px' }}>
										<div style={{ marginBottom: '15px' }}>
											<p style={{ margin: '0 0 8px 0', fontSize: '13px', fontWeight: '600' }}>{ __( 'Slide Image', 'pooki' ) }</p>
											<MediaUploadCheck>
												<MediaUpload
													onSelect={ ( media ) => {
														updateSlide( index, 'imageId', media.id );
														updateSlide( index, 'imageUrl', media.url );
														if( !slide.altText && media.alt ) {
															updateSlide( index, 'altText', media.alt );
														}
													} }
													allowedTypes={ [ 'image' ] }
													value={ slide.imageId }
													render={ ( { open } ) => (
														<div onClick={ open } style={{ cursor: 'pointer', background: '#f3f4f6', height: '160px', display: 'flex', alignItems: 'center', justifyContent: 'center', borderRadius: '6px', overflow: 'hidden', border: '1px dashed #d1d5db' }}>
															{ slide.imageUrl ? (
																<img src={ slide.imageUrl } style={{ width: '100%', height: '100%', objectFit: 'contain' }} />
															) : (
																<Button isSecondary>{ __( 'Select Image', 'pooki' ) }</Button>
															) }
														</div>
													) }
												/>
											</MediaUploadCheck>
										</div>

										<div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '15px' }}>
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
									</div>
								) }
							</div>
						);
					} ) }
				</div>
			</div>
		);
	},
	save: () => {
		// Render in PHP via render.php
		return null;
	},
} );
