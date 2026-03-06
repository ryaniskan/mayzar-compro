<?php $faq = $home_data['faq'] ?? []; ?>
<section class="faq section-padding style-4 pt-50" id="<?php echo $faq['anchor_id'] ?? 'faq'; ?>" data-scroll-index="7">
    <div class="container">
        <div class="section-head text-center style-4">
            <small class="title_small">
                <?php echo htmlspecialchars($faq['tagline'] ?? ''); ?>
            </small>
            <h2 class="mb-30">
                <?php echo $faq['title'] ?? ''; ?>
            </h2>
        </div>
        <div class="content">
            <div class="faq style-3 style-4">
                <div class="accordion" id="accordionSt4">
                    <div class="row gx-5">
                        <?php
                        $faqList = $faq['list'] ?? [];
                        $half = max(1, (int) ceil(count($faqList) / 2));
                        $chunks = array_chunk($faqList, $half);
                        foreach ($chunks as $colIdx => $colItems):
                            ?>
                            <div class="col-lg-6">
                                <?php foreach ($colItems as $itemIdx => $item):
                                    $uniqueId = "faq_" . $colIdx . "_" . $itemIdx;
                                    ?>
                                    <div class="accordion-item border-bottom rounded-0">
                                        <h2 class="accordion-header" id="heading_<?php echo $uniqueId; ?>">
                                            <button class="accordion-button collapsed rounded-0 py-4" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse_<?php echo $uniqueId; ?>"
                                                aria-expanded="false" aria-controls="collapse_<?php echo $uniqueId; ?>">
                                                <?php echo htmlspecialchars($item['question']); ?>
                                            </button>
                                        </h2>
                                        <div id="collapse_<?php echo $uniqueId; ?>"
                                            class="accordion-collapse collapse rounded-0"
                                            aria-labelledby="heading_<?php echo $uniqueId; ?>" data-bs-parent="#accordionSt4">
                                            <div class="accordion-body">
                                                <?php echo nl2br(htmlspecialchars($item['answer'])); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>