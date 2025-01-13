<?php

use PHPUnit\Framework\TestCase;

class InvoiceTest extends TestCase
{
    private $invoice;

    protected function setUp(): void
    {
        // Include necessary files
        require_once '../invoice.php';
        require_once '../includes/config.php';

        // Initialize the invoice class
        $this->invoice = new invoicr("A4", "RM", "en");
    }

    protected function tearDown(): void
    {
        // Cleanup: Delete the generated PDF file if it exists
        $filePath = 'sample.pdf';
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    public function testInvoiceGeneration()
    {
        // Set up invoice properties
        $this->invoice->setNumberFormat('.', ',');
        $this->invoice->setLogo("images/ambient-lounge-logo.gif", 356, 95);
        $this->invoice->setColor("#007bff"); // Blue theme
        $this->invoice->setType("Invoice");
        $this->invoice->setReference("MY-INV-000001");
        $this->invoice->setDate(date('d.m.Y', time()));
        $this->invoice->setDue(date('d.m.Y', strtotime('+30 days')));

        // Set company details (From)
        $this->invoice->setFrom([
            "MY Tech Solutions Sdn Bhd",
            "No. 12, Jalan Teknologi",
            "Taman Industri Malaysia",
            "Kuala Lumpur, 56000",
            "Wilayah Persekutuan, Malaysia",
            "Company No: 1234567-M",
            "Company SST: SST-123-4567",
        ]);

        // Set client details (To)
        $this->invoice->setTo([
            "Borneo Retail Ventures",
            "Level 5, Lot 10 Shopping Mall",
            "Jalan Bukit Bintang",
            "Kuala Lumpur, 55100",
            "Wilayah Persekutuan, Malaysia",
        ]);

        // Set shipping details (optional)
        $this->invoice->shipTo([
            "Ahmad Faisal",
            "Level 5, Lot 10 Shopping Mall",
            "Jalan Bukit Bintang",
            "Kuala Lumpur, 55100",
            "Wilayah Persekutuan, Malaysia",
        ]);

        // Add items
        $this->invoice->addItem(
            "Dell Inspiron Laptop",
            "Intel i7 Processor, 16GB RAM, 512GB SSD",
            2, "10%", 3500, 0, 7000
        );
        $this->invoice->addItem(
            "Logitech MX Master 3 Mouse",
            "Wireless Ergonomic Mouse",
            1, "10%", 450, 0, 450
        );

        // Add totals
        $this->invoice->addTotal("Total (Excl. SST)", 7450);
        $this->invoice->addTotal("SST (10%)", 745); // Assuming 10% SST
        $this->invoice->addTotal("Total (Incl. SST)", 8195, true);

        // Add payment information
        $this->invoice->addTitle("Payment Information");
        $this->invoice->addParagraph(
            "Please make payment via bank transfer to the following account:<br>
            Bank Name: Maybank<br>
            Account Name: MY Tech Solutions Sdn Bhd<br>
            Account Number: 112-233-4455<br>
            SWIFT Code: MBBEMYKL<br>
            <br>If you have any questions concerning this invoice, contact our finance department at finance@mytechsolutions.my.<br><br>Thank you for your business."
        );

        // Set footer
        $this->invoice->setFooternote("http://www.ambientlounge.co.uk");

        // Render the PDF
        $outputFile = 'testing.pdf';
        $this->invoice->render($outputFile, 'F'); // Save to file

        // Assertions
        $this->assertFileExists($outputFile, "The invoice PDF file was not generated.");
        $this->assertGreaterThan(0, filesize($outputFile), "The generated invoice PDF file is empty.");
    }
}
