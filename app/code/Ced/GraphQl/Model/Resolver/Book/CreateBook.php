<?php
/**
 * CedCommerce
  *
  * NOTICE OF LICENSE
  *
  * This source file is subject to the End User License Agreement (EULA)
  * that is bundled with this package in the file LICENSE.txt.
  * It is also available through the world-wide-web at this URL:
  * https://cedcommerce.com/license-agreement.txt
  *
  * @category  Ced
  * @package   Ced_GraphQl
  * @book    CedCommerce Core Team <connect@cedcommerce.com >
  * @copyright Copyright CEDCOMMERCE (https://cedcommerce.com/)
  * @license      https://cedcommerce.com/license-agreement.txt
  */
declare(strict_types=1);

namespace Ced\GraphQl\Model\Resolver\Book;

use Magento\Framework\Exception\AuthenticationException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlBookizationException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Ced\GraphQl\Model\Book;

/**
 * CreateBook Class
 */
class CreateBook implements ResolverInterface
{
    /**
     * @var Book
     */
    private $book;

    /**
     * 
     * @param Book $book
     */
    public function __construct(
        Book $book
    ) {
        $this->book = $book;
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        try {
            if (!isset($args['book_name'])) {
                throw new GraphQlInputException(__('"book_name" value should be specified'));
            }
            if (!isset($args['isbn_no'])) {
                throw new GraphQlInputException(__('"isbn_no" value should be specified'));
            }
            if (!isset($args['author'])) {
            	throw new GraphQlInputException(__('"author" value should be specified'));
            }
            if (!isset($args['publish_date'])) {
            	throw new GraphQlInputException(__('"publish_date" value should be specified'));
            }
            if (!isset($args['language'])) {
            	throw new GraphQlInputException(__('"language" value should be specified'));
            }
            if (!isset($args['mrp'])) {
            	throw new GraphQlInputException(__('"mrp" value should be specified'));
            }
            $this->book->addData($args);
            $this->book->getResource()->save($this->book);
            if($this->book->getId())
            return ['message'=>'Book Successfully Created', 'id' => $this->book->getId()];
            else 
            	return ['message'=>'Not Able To Create Book'];
        } catch (AuthenticationException $e) {
            throw new GraphQlBookizationException(
                __($e->getMessage())
            );
        }
    }
}
